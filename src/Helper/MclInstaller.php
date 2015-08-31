<?php
namespace Concrete\Package\ThemeSupermint\Src\Helper;
defined('C5_EXECUTE') or die(_("Access Denied."));

use Page;
use Package;
use SinglePage;
use PageType;
use BlockType;
use Block;
use PageTheme;
use Loader;
use Core;
use PageTemplate;
use CollectionAttributeKey;
use FileAttributeKey;
use UserAttributeKey;
use \Concrete\Core\Block\BlockType\Set as BlockTypeSet;
use \Concrete\Core\Attribute\Type as AttributeType;
use \Concrete\Core\Attribute\Key\Category as AttributeKeyCategory;
use Concrete\Core\Editor\Snippet as SystemContentEditorSnippet;

class MclInstaller
{

    protected static $mcBlockIDs = array();
    protected static $ptComposerOutputControlIDs = array();
    var $pkg;
    var $installedAk;

    function __construct($pkg) {
        $this->pkg = $pkg;
        $this->installedAk = array();
    }

    public function importContentFile($file)
    {
        $sx = simplexml_load_file($file);
        $this->doImport($sx);
    }

    public function importContentString($string)
    {
        $sx = simplexml_load_string($string);
        $this->doImport($sx);
    }

    protected function doImport($sx)
    {
        $this->importSinglePage($sx);
        $this->importBlockTypes($sx);
        $this->importBlockTypeSets($sx);
        $this->importAttributeCategories($sx);
        $this->importAttributeTypes($sx);
        $this->importAttributes($sx);
        $this->importAttributeSets($sx);
        $this->importThemes($sx);
        $this->importPageTemplates($sx);
        $this->importFileImportantThumbnailTypes($sx);
        $this->importSystemContentEditorSnippets($sx);
    }

    protected function getPackageObject()
    {
        return $this->pkg;
    }

    protected function importSinglePage(\SimpleXMLElement $sx)
    {

        if (isset($sx->singlepages)) {
            foreach ($sx->singlepages->page as $p) {
                $pkg = $this->getPackageObject();
                $sP = Page::getByPath($p['path']);
                if (!is_object($sP) || $sP->isError()) {
                    $sP = SinglePage::add($p['path'],$pkg);
                    $sP->update(array('cName' => $p['name'], 'cDescription' => $p['description']));
                }
            }
        }
    }


    protected function importPageTemplates(\SimpleXMLElement $sx)
    {
        if (isset($sx->pagetemplates)) {
            foreach ($sx->pagetemplates->pagetemplate as $pt) {
                $pkg = $this->getPackageObject();
                $ptt = PageTemplate::getByHandle($pt['handle']);
                if (!is_object($ptt)) {
                    $ptt = PageTemplate::add(
                        (string)$pt['handle'],
                        (string)$pt['name'],
                        (string)$pt['icon'],
                        $pkg,
                        (string)$pt['internal']
                    );
                }
            }
        }
    }

    protected function importBlockTypes(\SimpleXMLElement $sx)
    {
        if (isset($sx->blocktypes)) {
            foreach ($sx->blocktypes->blocktype as $bt) {
                $pkg = $this->getPackageObject();
                if (is_object($pkg)) {
                    if (!BlockType::getByHandle((string) $bt['handle']))
                        BlockType::installBlockTypeFromPackage((string) $bt['handle'], $pkg);
                } 
            }
        }
    }

    protected function importAttributeTypes(\SimpleXMLElement $sx)
    {
        if (isset($sx->attributetypes)) {
            foreach ($sx->attributetypes->attributetype as $at) {
                $pkg = $this->getPackageObject();
                $name = $at['name'];
                if (!$name) {
                    $name = Loader::helper('text')->unhandle($at['handle']);
                }
                $type = AttributeType::getByHandle($at['handle']);
                if (!is_object($type)) {
                    $type = AttributeType::add($at['handle'], $name, $pkg);
                }
                if (isset($at->categories)) {
                    foreach ($at->categories->children() as $cat) {
                        $catobj = AttributeKeyCategory::getByHandle((string)$cat['handle']);
                        $catobj->associateAttributeKeyType($type);
                    }
                }
            }
        }
    }

    protected function importThemes(\SimpleXMLElement $sx)
    {
        if (isset($sx->themes)) {
            foreach ($sx->themes->theme as $th) {
                $pkg = $this->getPackageObject();
                $pThemeHandle = (string)$th['handle'];
                $pt = PageTheme::getByHandle($pThemeHandle);
                if (!is_object($pt)) {
                    $pt = PageTheme::add($pThemeHandle, $pkg);
                }
                if ($th['activated'] == '1' && is_object($pt)) {
                    $pt->applyToSite();
                }
            }
        }
    }

    protected function importFileImportantThumbnailTypes(\SimpleXMLElement $sx)
    {
        if (isset($sx->thumbnailtypes)) {
            foreach ($sx->thumbnailtypes->thumbnailtype as $l) {
                $thumbtype = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle((string) $l['handle']);
                if (is_object($thumbtype)) continue;
                
                $type = new \Concrete\Core\File\Image\Thumbnail\Type\Type();
                $type->setName((string) $l['name']);
                $type->setHandle((string) $l['handle']);
                $type->setWidth((string) $l['width']);
                $required = (string) $l['required'];
                if ($required) {
                    $type->requireType();
                }
                $type->save();
            }
        }
    }
    

    protected function importAttributeCategories(\SimpleXMLElement $sx)
    {
        if (isset($sx->attributecategories)) {
            foreach ($sx->attributecategories->category as $akc) {
                $pkg = $this->getPackageObject();
                $akx = AttributeKeyCategory::getByHandle($akc['handle']);
                if (!is_object($akx)) {
                    $akx = AttributeKeyCategory::add($akc['handle'], $akc['allow-sets'], $pkg);
                }
            }
        }
    }

    protected function importAttributes(\SimpleXMLElement $sx)
    {
        if (isset($sx->attributekeys)) {
            $db = Loader::db();
            foreach ($sx->attributekeys->attributekey as $ak) {

                $akc = AttributeKeyCategory::getByHandle($ak['category']);
                $pkg = $this->getPackageObject();
                $type = AttributeType::getByHandle($ak['type']);
                $txt = Loader::helper('text');
                $c1 = '\\Concrete\\Core\\Attribute\\Key\\' . $txt->camelcase(
                        $akc->getAttributeKeyCategoryHandle()
                    ) . 'Key';

                $akID = $db->GetOne( "SELECT ak.akID FROM AttributeKeys ak INNER JOIN AttributeKeyCategories akc ON ak.akCategoryID = akc.akCategoryID  WHERE ak.akHandle = ? AND akc.akCategoryHandle = ?", array($ak['handle'],  $akc->getAttributeKeyCategoryHandle()));

                if(!$akID) 
                    call_user_func(array($c1, 'import'), $ak);
                    // ISSUE : This create tha attribute but this one is not loadable for now, i think from a cache issue.
                    // It is impossible to retrieve the attribute to embed in a set for example.
                    // So we work directly with DB
                    $row = $db->GetRow(
                        'select akID, akHandle from AttributeKeys inner join AttributeKeyCategories on AttributeKeys.akCategoryID = AttributeKeyCategories.akCategoryID inner join AttributeTypes on AttributeKeys.atID = AttributeTypes.atID where akHandle = ? and akCategoryHandle = ?',
                        array($ak['handle'], $akc->getAttributeKeyCategoryHandle())
                    );
                    // We save atHandle and Id in a array to retrieve it later in attributeSet
                    if (count($row)) :
                        $new_akID = $row['akID'];
                        // We need to change the value 'akIsAutoCreated' for file attribute otherwise it is not available in the file properties
                        if ($ak['category'] == 'file') 
                            $db->Execute('UPDATE AttributeKeys SET akIsAutoCreated = 0 WHERE AttributeKeys.akID = ?',array($new_akID));                        
                        $this->installedAk[$row['akHandle']] = $new_akID;
                    endif;
            }
        }
    }

    protected function importAttributeSets(\SimpleXMLElement $sx)
    {
        if (isset($sx->attributesets)) {
            $db = Loader::db();
            foreach ($sx->attributesets->attributeset as $as) {
                $set = \Concrete\Core\Attribute\Set::getByHandle((string) $as['handle']); // Ici il faudrait que l'on charge un set relatif a uen categorie, au sinon, les set ne peuvent pas avoir les meme handle suivant les catégories
                $akc = AttributeKeyCategory::getByHandle($as['category']);
                if (!is_object($set)) {
                    $pkg = $this->getPackageObject();
                    $set = $akc->addSet((string)$as['handle'], (string)$as['name'], $pkg, $as['locked']);
                }
                // var_dump($akc);
                foreach ($as->children() as $ask) {
                    $akID = $this->installedAk[(string)$ask['handle']];
                    if($akID) {
                        $no = $db->GetOne("select count(akID) from AttributeSetKeys where akID = ? and asID = ?", array($akID, $set->getAttributeSetID()));
                        if ($no < 1) {
                            $do = $db->GetOne('select max(displayOrder) from AttributeSetKeys where asID = ?', array($set->getAttributeSetID()));
                            $do++;
                            $db->Execute('insert into AttributeSetKeys (asID, akID, displayOrder) values (?, ?, ?)', array($set->getAttributeSetID(), $akID, $do));
                        }                   
                    } else {
                        $ak = $akc->getAttributeKeyByHandle((string)$ask['handle']);
                        if (is_object($ak)) {
                            $set->addKey($ak);
                        }
                    }
                }
            }
        }
    }

    protected function importSystemContentEditorSnippets(\SimpleXMLElement $sx)
    {
        if (isset($sx->systemcontenteditorsnippets)) {
            foreach ($sx->systemcontenteditorsnippets->snippet as $th) {
                $pkg = $this->getPackageObject();
                $scs = SystemContentEditorSnippet::getByHandle($th['handle']);
                if (is_object($scs)) continue;
                $scs = SystemContentEditorSnippet::add($th['handle'], $th['name'], $pkg);
                $scs->activate();                
            
            }
        }
    }

    protected function importBlockTypeSets(\SimpleXMLElement $sx)
    {
        if (isset($sx->blocktypesets)) {
            foreach ($sx->blocktypesets->blocktypeset as $bts) {
                $pkg = $this->getPackageObject();
                $set = BlockTypeSet::getByHandle((string)$bts['handle']);
                if (!is_object($set)) {
                    $set = BlockTypeSet::add((string)$bts['handle'], (string)$bts['name'], $pkg);
                    foreach ($bts->children() as $btk) {
                        $bt = BlockType::getByHandle((string)$btk['handle']);
                        if (is_object($bt)) {
                            $set->addBlockType($bt);
                        }
                    }

                }
            }
        }
    }

}
