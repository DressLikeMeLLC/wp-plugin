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
                title : 'DressLikeMe - Your Outfit',
                cmd : 'dlm_outfit_command',
                icon : 'icon dashicons-products'
            });

            ed.addCommand('dlm_outfit_command', function() {
                ed.windowManager.open(

                    {
                        title: 'DressLikeMe - Your Outfit',
                        file:  url + '/../views/tinymce-outfit.php',
                        width: diWidth,
                        height: 800,
                        inline: 1
                    },

                    {
                        editor: ed,
                        jquery: $,
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
                longname : "DressLikeMe - Your Recent Outfits",
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.create('tinymce.plugins.dlm_outfits', {

        init : function(ed, url) {

            ed.addButton('dlm_outfits_button', {
                title : 'DressLikeMe - Your Recent Outfits',
                cmd : 'dlm_outfits_command',
                icon : 'icon dashicons-products'
            });

            ed.addCommand('dlm_outfits_command', function() {
                ed.windowManager.open(

                    {
                        title: 'DressLikeMe - Your Recent Outfits',
                        file:  url + '/../views/tinymce-outfits.php',
                        width: 325,
                        height: 210,
                        inline: 1
                    },

                    {
                        editor: ed,
                        jquery: $,
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
                longname : "DressLikeMe - Your Recent Outfits",
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.create('tinymce.plugins.dlm_wardrobe', {

        init : function(ed, url) {

            ed.addButton('dlm_wardrobe_button', {
                title : 'DressLikeMe - Your Wardrobe',
                cmd : 'dlm_wardrobe_command',
                icon : 'icon dashicons-businessman'
            });

            ed.addCommand('dlm_wardrobe_command', function() {
                ed.windowManager.open(
                    {
                        title: 'DressLikeMe - Your Wardrobe',
                        file:  url + '/../views/tinymce-wardrobe.php',
                        width: 325,
                        height: 210,
                        inline: 1
                    },

                    {
                        editor: ed,
                        ajaxurl: ajaxurl,
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
                longname : "DressLikeMe - Your Wardrobe",
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.create('tinymce.plugins.dlm_product', {

        init : function(ed, url) {

            ed.addButton('dlm_product_button', {
                title : 'DressLikeMe - Add Product',
                cmd : 'dlm_product_command',
                icon : 'icon dashicons-cart'
            });

            ed.addCommand('dlm_product_command', function() {
                ed.windowManager.open(

                    {
                        title: 'DressLikeMe - Add Product',
                        file:  url + '/../views/tinymce-product.php',
                        width: 335,
                        height: 800,
                        inline: 1
                    },

                    {
                        editor: ed,
                        jquery: $,
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
                longname : "DressLikeMe - Add Product",
                author : "dresslikeme.com",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("dlm_outfit", tinymce.plugins.dlm_outfit);
    tinymce.PluginManager.add("dlm_outfits", tinymce.plugins.dlm_outfits);
    tinymce.PluginManager.add("dlm_wardrobe", tinymce.plugins.dlm_wardrobe);
    tinymce.PluginManager.add("dlm_product", tinymce.plugins.dlm_product);
})(jQuery);