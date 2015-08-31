<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<div class="mcl-edit">
<form action="<?php  echo $this->action('edit_preset')?>" method="post" >
    <div class="">
        <div class="section"><h3><?php echo t('Manage Presets') ?></h3></div>
        <table class="entry-form preset-table">
            <th><strong><?php  echo t("Name"); ?></strong></th>
            <th><strong><?php  echo t("ID"); ?></strong></th>
            <th><strong><?php  echo t("Rename"); ?></strong></th>
            <th><strong><?php  echo t("Default Selection"); ?></strong></th>
            <th><strong><?php  echo t("Delete"); ?></strong></th>
            <th><strong><?php  echo t("Export"); ?></strong></th>
            
    <?php  foreach ($list as $k=>$p) :
            //$u = User::getByUserID($p['creator']);
        ?>
            <tr <?php  if ($p['pID'] == $poh->get_default_pID()) : ?> style="background:rgb(221, 226, 231)"<?php  endif ?>>
                <td class="title"><?php  if ($p['pID'] == $poh->get_default_pID()) : ?><strong><?php  endif?><?php  echo $p['name']?><?php  if ($p['pID'] == $poh->get_default_pID()) : ?></strong><?php  endif?></td>
                <td><?php echo $p['pID'] ?></td>
                <td>
                    <input type="text" name="rename_<?php  echo $p['pID']?>" class="ccm-input-text" style="width:60%" />
                    <input type="submit" name="preset_to_rename_<?php  echo $p['pID']?>" value="<?php  echo t('Rename');?>" class="btn btn-primary" />
                </td>
                <td>
                    <?php  if ($p['pID'] != $poh->get_default_pID()) : ?>
                        <input type="submit" name="set_as_default_<?php  echo $p['pID']?>" value="<?php  echo t('Set as Default'); ?>" class="btn btn-primary primary" />
                    <?php  else : ?>
                        <strong><?php  echo t("Choosed as default"); ?></strong>
                    <?php  endif ?>
                </td>
                <td>
                    <?php  if ($k != 0):?>
                        <input type="submit" name="preset_to_delete_<?php  echo $p['pID']?>" value="<?php  echo t('Delete'); ?>" class="btn btn-primary error" />
                    <?php  else : ?>
                        <input type="submit" name="preset_to_reset_<?php  echo $p['pID']?>" value="<?php  echo t('Reset Values'); ?>" class="btn btn-primary error" />
                    <?php  endif ?>
                <td>
                    <a class="btn btn-primary" target="_blank" href="<?php echo URL::to('/ThemeSupermint/tools/xml_preset');?>?pid=<?php  echo $p['pID']?>"><?php echo t('Export') ?></a>
                </td>
                </td>
            </tr>
        <?php  endforeach ?>
        </table>
    </div>

<div style="height:60px"></div>

</form>

    <div class="">
        <div class="section"><h3><?php echo t('Add a Preset') ?></h3></div>
        <form action="<?php  echo $this->action('save_preset')?>" method='post'>
        <table class="entry-form preset-table">
            <tr>
                <th style="width:44%"><strong><?php  echo t("Name"); ?></strong></th>
                <th style="width:33%"><strong><?php  echo t("Based on"); ?></strong></th>
                <th style="width:23%"><strong><?php  echo t("Add"); ?></strong></th>
            </tr>
            <tr>
                <td><input type="text" name="name" style="width:95%" /></td>
                <td><?php  $poh->output_presets_list(true, 1, 'preset_id')?></td>
                <td><input type="submit" class="btn btn-primary primary" name="new" value="<?php  echo t('Add'); ?>" /></td>
            </tr>
        </table>
        </form>
        <div style="height:60px">&nbsp; </div>

        <div class="section"><h3><?php echo t('Export a Preset') ?></h3></div>        
        <form enctype="multipart/form-data" action="<?php  echo $this->action('import_preset')?>" method="post">
        <table cellpadding="20" cellspacing="1" class="entry-form zebra-striped" style="background:rgb(221, 226, 231)">
            <tr>
                <td style="width:50%">
                    <h2><?php echo t('Import a preset') ?></h2>
                    <p><?php echo t('Preset can be imported and exported.') ?></p>                                
                </td>
                <td>
                        <input id="appendedInputButtons" name="userfile" type="file" title="<?php echo t('Pick a .mcl file') ?>">
                        <input type="hidden" name="MAX_FILE_SIZE" value="10000" />                    
                </td>
                <td>
                        <button class="btn btn-primary" type="submit" ><?php echo t('Load preset') ?></button>
                </td>
            </tr>
        </table>
         </form>                    
    </div>
</div>


<style>
    .entry-form {
        width: 100%
    }
    .entry-form td {
        padding: 10px 5px;
    }
</style>