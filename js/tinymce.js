(function($) {
    tinymce.create('tinymce.plugins.dlm_outfit', {

        init : function(ed, url) {
            if($(window).width() > 900) {
                var diWidth = 680;
            }
            if ($(window).width() < 900) {
                var diWidth = 500;
            }
            if ($(window).width() < 600) {
                var diWidth = 300;
            }

            ed.addButton('dlm_outfit_button', {
                title : dlmTranslations.outfit,
                cmd : 'dlm_outfit_command',
                icon : 'icon dashicons-products'
            });

            ed.addCommand('dlm_outfit_command', function() {
                ed.windowManager.open(

                    {
                        title: dlmTranslations.outfit,
                        file:  url + '/../views/tinymce-outfit.php',
                        width: diWidth,
                        height: 800,
                        inline: 1
                    },

                    {
                        editor: ed,
                        jquery: $,
                        dlmTranslations: dlmTranslations,
                        ajaxurl: ajaxurl
                    }
                );
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : dlmTranslations.outfit,
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.create('tinymce.plugins.dlm_profile', {

        init : function(ed, url) {

            ed.addButton('dlm_profile_button', {
                title : dlmTranslations.profile,
                cmd : 'dlm_profile_command',
                icon : 'icon dashicons-format-image'
            });

            ed.addCommand('dlm_profile_command', function() {
                ed.windowManager.open(

                    {
                        title: dlmTranslations.profile,
                        file:  url + '/../views/tinymce-profile.php',
                        width: 325,
                        height: 210,
                        inline: 1
                    },

                    {
                        editor: ed,
                        jquery: $,
                        dlmTranslations: dlmTranslations,
                        ajaxurl: ajaxurl
                    }
                );
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : dlmTranslations.profile,
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.create('tinymce.plugins.dlm_outfits', {

        init : function(ed, url) {

            ed.addButton('dlm_outfits_button', {
                title : dlmTranslations.outfits,
                cmd : 'dlm_outfits_command',
                icon : 'icon dashicons-images-alt'
            });

            ed.addCommand('dlm_outfits_command', function() {
                ed.windowManager.open(

                    {
                        title: dlmTranslations.outfits,
                        file:  url + '/../views/tinymce-outfits.php',
                        width: 325,
                        height: 210,
                        inline: 1
                    },

                    {
                        editor: ed,
                        jquery: $,
                        dlmTranslations: dlmTranslations,
                        ajaxurl: ajaxurl
                    }
                );
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : dlmTranslations.outfits,
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.create('tinymce.plugins.dlm_wardrobe', {

        init : function(ed, url) {

            ed.addButton('dlm_wardrobe_button', {
                title : dlmTranslations.wardrobe,
                cmd : 'dlm_wardrobe_command',
                icon : 'icon dashicons-businessman'
            });

            ed.addCommand('dlm_wardrobe_command', function() {
                ed.windowManager.open(
                    {
                        title: dlmTranslations.wardrobe,
                        file:  url + '/../views/tinymce-wardrobe.php',
                        width: 325,
                        height: 320,
                        inline: 1
                    },

                    {
                        editor: ed,
                        ajaxurl: ajaxurl,
                        dlmTranslations: dlmTranslations,
                        jquery: $
                    }
                );
            });

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : dlmTranslations.wardrobe,
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.create('tinymce.plugins.dlm_product', {

        init : function(ed, url) {

            ed.addButton('dlm_product_button', {
                title : dlmTranslations.product,
                cmd : 'dlm_product_command',
                icon : 'icon dashicons-cart'
            });

            ed.addCommand('dlm_product_command', function() {
                ed.windowManager.open(

                    {
                        title: dlmTranslations.product,
                        file:  url + '/../views/tinymce-product.php',
                        width: 335,
                        height: 800,
                        inline: 1
                    },

                    {
                        editor: ed,
                        jquery: $,
                        dlmTranslations: dlmTranslations,
                        ajaxurl: ajaxurl
                    }
                );
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : dlmTranslations.product,
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("dlm_outfit", tinymce.plugins.dlm_outfit);
    tinymce.PluginManager.add("dlm_outfits", tinymce.plugins.dlm_outfits);
    tinymce.PluginManager.add("dlm_wardrobe", tinymce.plugins.dlm_wardrobe);
    tinymce.PluginManager.add("dlm_product", tinymce.plugins.dlm_product);
    tinymce.PluginManager.add("dlm_profile", tinymce.plugins.dlm_profile);
})(jQuery);