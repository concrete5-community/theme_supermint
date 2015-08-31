if (!RedactorPlugins) var RedactorPlugins = {};
 
 $.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        var n = this.name.replace(/[\[\]']+/g,'');
        if (o[n] !== undefined) {
            if (!o[n].push) {
                o[n] = [o[n]];
            }
            o[n].push(this.value || '');
        } else {
            o[n] = this.value || '';
        }
    });
    return o;
};


RedactorPlugins.themeclips = function()
{
    return {

        init: function ()
        {
            this.opts.replaceDivs = false;
            var dropdown = {};
            var f = this.themeclips.show;
            // On crée les éléments du menu avec pour chaque l'appel de la function show
            dropdown.hint = { title: 'Hover Hint', func:f};
            dropdown.alert = { title: 'Alert Message', func:f};
            dropdown.button = { title: 'Button', func:f};
            dropdown.divider = { title: 'Divider', func:f};
            dropdown.heading = { title: 'Heading', func:f};
            dropdown.icon = { title: 'Icon', func:f};
            dropdown.navigation = { title: 'Navigation', func:f};
            // dropdown.leftright = { title: 'Left & Right', func:f};
 
            var button = this.button.add('themeclips', 'themeclips');
            this.button.setAwesome('themeclips', 'fa-tasks');
            
            this.button.addDropdown(button, dropdown);
        },
        getTemplate: function(buttonName)
        {
            // l'objet correspondant au menu cliqué
            // ex: on clique sur hint, l'objet hint présent dans ce script.
            var clipObject = this.themeclips[buttonName];
            var select = this.selection.getHtml();
            return String()
            + '<section id="redactor-modal-themeclips" class="ccm-ui" data-launch="' + buttonName + '">'
            + '<form id="themeclipsform">'
            +  clipObject.getModal(this.themeclips, select)
            + '</form>'
            + '</section>';

        },        
        show: function(buttonName)
        {
            
            // On va chercher le contenu du modal avec comme parametre le nom du bouton
            this.modal.addTemplate('themeclips', this.themeclips.getTemplate(buttonName));
 
            this.modal.load('themeclips', 'Add a ' + buttonName, 500);
            this.modal.createCancelButton();
            var button = this.modal.createActionButton('Insert');
            button.on('click', this.themeclips.insert);
 
            this.selection.save();
            this.modal.show();

            // On active les Evenement sur les bouton sitemap et filemanager
           $('a[data-action=themeclip-link-from-sitemap]').on('click', function(e) {
                e.preventDefault();
                jQuery.fn.dialog.open({
                    width: '90%',
                    height: '70%',
                    modal: false,
                    title: ccmi18n_sitemap.choosePage,
                    href: CCM_TOOLS_PATH + '/sitemap_search_selector'
                });
                ConcreteEvent.unsubscribe('SitemapSelectPage');
                ConcreteEvent.subscribe('SitemapSelectPage', function(e, data) {
                    jQuery.fn.dialog.closeTop();
                    var url = CCM_APPLICATION_URL + '/index.php?cID=' + data.cID;
                    $('#redactor-link-url').val(url);
                });
            });
            $('a[data-action=themeclip-file-from-file-manager]').on('click', function(e) {
                e.preventDefault();
                ConcreteFileManager.launchDialog(function(data) {
                    jQuery.fn.dialog.showLoader();
                    ConcreteFileManager.getFileDetails(data.fID, function(r) {
                        jQuery.fn.dialog.hideLoader();
                        var file = r.files[0];
                        $('#redactor-link-url').val(file.urlDownload);
                    });
                });
            });           
        },
        // Apellé quand l'utilisateur a cliqué sur OK du modal.
        insert: function()
        {
            // Le Modal
            var modal = $("#redactor-modal-themeclips");
            // On recupère l'object lié à ce bouton
            var clipObject = this.themeclips[modal.data('launch')];

            // On rempli l'object représentant le formulaire
            var form = $("#themeclipsform").serializeObject();
 
            this.modal.close();
            this.selection.restore();
            // On prend le texte séléctionné
            var text = this.selection.getHtml();
            // On ENFIN, on prend le clip
            var html = clipObject.getContent(text, form,this.themeclips);
            this.themeclips.pasteHtmlAtCaret(html);
            
            this.code.sync();
 
        },

        /* -- CLips -- */

        hint : {
            getModal : function (t, selected) {
                return String()
                    + t.textInput('content', '') 
                    + t.colorSelect(["black","success","info","warning","error"],true) 
                    + t.selectInput('position',["top","bottom","left","right"])
                    + t.checkboxInput('option', ["rounded", "bounce"]);
                
            },
            getContent : function (text, form, t) {
                // si aucin texte n'a été séléctioné, on ne fait rien
                if (!text) return;
                var hintOptions = t.getCheckboxesString(form.option,"hint--");
                return String()
                    + '<span class="'
                        + ' hint--' + form.position 
                        + ' hint--' + form.color 
                        + hintOptions
                        + '" data-hint="' + form.content + '"> ' + text + '</span>';
            }
        },

        alert : {
            getModal : function (t, selected) {
                return String()
                    + t.textInput('title', '') 
                    + t.textInput('content', selected) 
                    + t.colorSelect(["success","info","warning","danger"],true);
                
            },
            getContent : function (text, form) {
                return String()
                    + '<section class="alert alert-' + form.color + ' alert-dismissible" role="alert" data-redactor="verified">'
                    + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                    + ( form.title != '' ? '<h4>' + form.title + '</h4>' : '' )
                    + '<p>' + form.content + '</p>'
                    + '</section>';
            }
        },
        button : {
            getModal : function (t, selected) {
                return String()
                    + t.textInput('content',selected)
                    + t.linkInput('link')
                    + t.colorSelect(["default","primary","success","info","warning","danger"],true)
                    + t.selectInput('type',['flat','push','plain'])
                    + t.selectInput('size',['tiny','small','big','huge'], 'small')
                    + t.awesomeSelect('icon')                    
                    + t.checkboxInput('Display block', ["block"]);
                
            },
            getContent : function (text, form) {
                return String()
                    + '<a href="' + form.link + '" class="button button-' + form.color + ' button-' + form.type + ' button-' + form.size + ' ' +  (form.block == 'block' ? 'button-block' : '') + '" target="' + form.target + '">'
                    + (form.icon ? '<span class="icon"><i class="fa ' + form.icon + ' fa-fw"></i></span> ' : '' )
                    + form.content
                    + '</a>';
            }
        },
        divider : {
            getModal : function (t, selected) {
                return String()
                    + t.checkboxInput('type',['space-s','space-m','space-l']);
                
            },    
            getContent : function (text, form, t) {
                // On doit tester le type pour les elements checkbox et agir en conséquence
                var hrclasses = t.getCheckboxesString(form.type);

                return String()
                    + '<hr class="' + hrclasses + '" />';
            }                    
        },
        heading : {
            getModal : function (t, selected) {
                return String() 
                    + t.textInput('main', selected) 
                    + t.textInput('second', '')
                    + t.selectInput('level',['h1','h2','h3','h4','h5','h6','em'],'h3')
                    + t.selectInput('styling',['heading-small','space-dotted'],'heading-small');
                
            },    
            getContent : function (text, form, t) {
                switch (form.styling) {
                    case 'heading-small' :
                        return String()
                            + '<' + form.level + '>' + form.main 
                            + ' <small>' + form.second + '</small>'
                            + '</' + form.level + '>';
                        break;
                    case 'space-dotted' :
                        return String()
                            + '<' + form.level + ' class="leaders"><i>' + form.main 
                            + '</i><i>' + form.second + '</i>'
                            + '</' + form.level + '>';
                        break;
                };
            }                    
        },
        leftright : {
            getModal : function (t, selected) {
                return String() 
                    // + t.awesomeSelect('icon_left') 
                    + t.textInput('left', selected || '&nbsp;') 
                    + t.textInput('right', '&nbsp;')
                    + t.selectInput('size',['small','p','h6','h5','h4'],'p');
                
            },    
            getContent : function (text, form, t) {
                // var icon = form.icon_left != 'none' ? ('<i class="fa ' + form.icon_left + '"></i> ') : '';
                var html = String();
                    html 
                    += '<section class ="left-right clearfix ' + form.size + '">'
                    + ' <aside class="left">'  + '<' + form.size + '>' + form.left + '</' + form.level + '>'+ '</aside>'
                    + ' <article class="right">' + '<' + form.size + '>' + form.right  + '</' + form.size + '>' + '</article>'
                    + ' </section>';
                return html;
            }                    
        },
        icon : {
            getModal : function (t) {
                return String() 
                    + t.awesomeSelect('icon')                    
                    + t.selectInput('size',['default','lg','2x','3x','4x','5x'])
                    + t.selectInput('animate',['none','spin','pulse'])
                    + t.selectInput('stacked',['none','circle','square','square-o'])
                    + t.colorSelect(["default","success","info","warning","danger"],false,'default')
                    + t.selectInput('align',['none','left','right'])
                    ;
            },    
            getContent : function (text, form, t) {
                var html = String();
                    // Si pas d'icone, pas d'icone !
                    if (form.icon == 'none') return html;
                    
                    var size = form.size != 'default' ? ('fa-' + form.size + ' ') : ' ';
                    var animate = form.animate != 'none' ? ('fa-' + form.animate + ' ') : ' ';
                    var color = form.color != 'default' ? ('text-' + form.color + '-color ') : ' ';
                    var align = form.align != 'none' ? (' ' + form.align) : '';

                    if (form.stacked == 'none') {
                        html += '<span><i class="fa ' + size + animate + color + form.icon + align + '"></i></span> '
                    } else {                        
                        if (form.stacked != 'square-o') {
                            var inverse = form.color != 'default' ? (' text-' + form.color + '-contrast-color ') : ' ';
                        } else {
                            var inverse = form.color != 'default' ? (' text-' + form.color + '-color ') :' fa-inverse';
                        } 
                        html += '<span class="fa-stack ' + size + align + '">'
                                + '<i class="fa fa-' + form.stacked + ' ' + color + ' fa-stack-2x"></i>'  // La forme du stack
                                + '<i class="fa ' + form.icon + inverse + ' fa-stack-1x"></i>'      // L'icone
                             + '</span>'
                    }

                    return html;
            }                    
        },
        navigation : {
            getModal : function (t, selected) {
                return String()
                    + t.selectInput('type',['horizontal','horizontal-light','vertical'])
                    + t.selectInput('size',['default','small'])
                    + t.selectInput('align',['align-default','align-right']);
                
            },
            getContent : function (text, form) {
                return String()
                    + '<ul class="nav custom-nav nav-' 
                        + form.type 
                        + ' nav-' + form.size 
                        + ' nav-' + form.align
                        + '"><li>'
                    + (text || 'Link here') + '</li></ul>';
            }                               
        },        
        /* -- Form Elements -- */
        
        colorSelect : function (additionalColors,merge,select) {
                name = "color";
                select = select ? select : "primary";
                var colors = new Array("primary", "secondary","tertiary","quaternary");
                // Si merrge est true, on mélange les deux tableau, sinon, on ne prend que les arguments
                if (!merge)
                    var classes = additionalColors ? $.merge(colors,additionalColors) : colors;
                else if(additionalColors)
                    var classes = additionalColors;

                var html = String()
                + '<div class="form-group">'
                + this.themeclips.getLabel(name)
                + '<select name="color" class="form-control">';
                $.each(classes, function(i,t){
                    html += '<option value="' + t + '"  ' + (select == t ? 'selected' : '') + '>' + t + '</option>';
                });                     
                html += '</select>'
                + '</div>';         
                return html;
        },

        selectInput : function (name,array,select) {
                var html = String()
                + '<div class="form-group">'
                + this.themeclips.getLabel(name)

                + '<select name="' + name + '" class="form-control">';
                $.each(array, function(i,t){
                    html += '<option value="' + t + '" ' + (select == t ? 'selected' : '') + '>' + t + '</option>';
                });                     
                html += '</select>'
                + '</div>';         

                return html;
        },

        awesomeSelect : function (name,array,select) {
            var plugin = this.themeclips;
            var that = this;


            var html = String()
                + '<div class="form-group">'
                + this.themeclips.getLabel(name)
                + '<select name="' + name + '" class="form-control chosenicon" id="themeclips_choose_awesome">'
                + '<option value="" data-icon="none">None</option>'
                + '</select>'
                + '</div>';

            if (typeof plugin.awesomeIcons === 'object') {
                setTimeout(function(){ plugin.setAwesomeOptions(plugin.awesomeIcons) }, 500);
                
                return html;
            }

            $.ajax({
                'type': 'post',
                'dataType': 'json',
                'url': CCM_DISPATCHER_FILENAME + '/ThemeSupermint/tools/get_awesome_icons',
                'data': {
                    'ccm_token': CCM_EDITOR_SECURITY_TOKEN,
                    'isJson': 1
                },

                success: function(icons) {
                    plugin.awesomeIcons = icons;
                    plugin.setAwesomeOptions(icons);
                }
            });

            return html;

        },

        checkboxInput : function (name,array,select) {
                var html = String()
                + '<div class="form-group">'
                + this.themeclips.getLabel(name)
                +  '<div>&nbsp;</div>';
                
                $.each(array, function(i,t){
                    html += '<label>' 
                         +  '<input type="checkbox" name="' + name + '[]" value="' + t + '" ' + (select == t ? 'checked' : '') + ' />' + t 
                         +  '</label>'
                         +  '</br>';
                });                     
                html += '</div>';         

                return html;
        },

        textInput : function (name,value) {
             return String()
                + '<div class="form-group">'
                + this.themeclips.getLabel(name)
                + '<input name="' + name + '" value="' + value + '"  class="form-control" />'
                + '</div>';         
        },

        linkInput : function (name) {$
            return String()
                + '<div class="form-group">'
                + this.themeclips.getLabel(name)
                + '<div class="input-group">'
                + '<input type="text" class="form-control" id="redactor-link-url" name="' + name + '"/>'
                + '<a href="#" data-action="themeclip-link-from-sitemap" class="btn btn-default input-group-addon"><i class="fa fa-sitemap"></i></a>'
                + '<a href="#" data-action="themeclip-file-from-file-manager" class="btn btn-default input-group-addon"><i class="fa fa-file"></i></a>'
                + '</div>'
                + '</div>'
                + this.themeclips.selectInput('target',['_self','_blank']);
        },

        /* -- Utils -- */

        getLabel : function (name) {
            return String() + '<label class="control-label" for="' + name + '">' + this.themeclips.capitalizeFirstLetter(name.replace(new RegExp('_', 'g'), ' ').toUpperCase()) + '</label>'
        },

        getCheckboxesString : function (formResult, prefix, asArray) {
                // On doit tester le type pour les elements checkbox et agir en conséquence
                var returnArray=  new Array();
                if (typeof formResult === 'object' ) $.each(form.option,function(i,t){ returnArray.push(t) });
                if (typeof formResult === 'string' ) returnArray.push(formResult);    
                
                if (prefix) {
                    var temp =  new Array();
                    $.each(returnArray,function(i,t){ temp.push( prefix + t ) });
                    returnArray = temp;
                }
                
                if (asArray)
                    return returnArray;
                else 
                    return returnArray.join(' ');
                    
        },

        setAwesomeOptions : function (icons) {

            $.each (icons, function (ihandle,iname) {
                var option = $('<option value="' + ihandle + '" data-icon="' + ihandle + '">' + iname + '</option>');
                $('#themeclips_choose_awesome').append(option);                            
            });
            $("#themeclips_choose_awesome").chosenIcon({width: "95%"});          
        },

        pasteHtmlAtCaret : function (html) {
            // On rajoute un paragrahe vide pour que le curseur s'y place et 
            //permette l'ajout d'autres elements
            // html += '<p>&nbsp;</p>';
            var sel, range;
            if (window.getSelection) {
                // IE9 and non-IE
                sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    range = sel.getRangeAt(0);
                    range.deleteContents();

                    var el = document.createElement("div");
                    el.innerHTML = html;
                    var frag = document.createDocumentFragment(), node, lastNode;
                    while ( (node = el.firstChild) ) {
                        lastNode = frag.appendChild(node);
                    }
                    range.insertNode(frag);

                    // Preserve the selection
                    if (lastNode) {
                        range = range.cloneRange();
                        range.setStartAfter(lastNode);
                        range.collapse(true);
                        sel.removeAllRanges();
                        sel.addRange(range);
                    }
                }
            } else if (document.selection && document.selection.type != "Control") {
                // IE < 9
                document.selection.createRange().pasteHTML(html);
            }
        },

        capitalizeFirstLetter : function (string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }       

    };
};

