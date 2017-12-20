<!DOCTYPE html>
<html>
<head>
    <!-- Disable browser caching of dialog window -->
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <link rel="stylesheet" id="open-sans-css" href="https://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&amp;subset=latin%2Clatin-ext&amp;ver=4.5.2" type="text/css" media="all">
</head>
<body>
<div class="error-dlm"></div>
<form class="product-search">
    <input type="text" name="search" required id="search" /><br><br>
    <input type="submit" value="Search for this product." />
</form> <br>
<div class="images-dlm"></div>
<br>

<script>
    var passed_arguments = top.tinymce.activeEditor.windowManager.getParams(),
        ajaxurl = passed_arguments.ajaxurl,
        $ = passed_arguments.jquery,
        jqContext = document.getElementsByTagName("body")[0],
        $dlmImages = $('div.images-dlm', jqContext);

    $.post(ajaxurl, {
        action: 'dlm_json_action'
    }, function(data) {
        var json = $.parseJSON(data);
        if (!json || !json.length) {
            $('form', jqContext).html('');
            $('div.error-dlm', jqContext).append('Please update the settings of your DressLikeMe plugin.');
            $('div.error-dlm', jqContext).append('<br>');
            $('div.error-dlm', jqContext).append('<a href="/wp-admin/admin.php?page=dlm" target="_blank" class="button-primary">Your settings</a>');
        }
    });

    $('form', jqContext).submit(function(event) {
        event.preventDefault();
        $.post(ajaxurl, {
            action: 'dlm_product_json_action',
            search: $("input[name='search']", jqContext).val()
        }, function(data) {
            var json = $.parseJSON(data);
            if (!json || !json.length) {
                $('div.error-dlm', jqContext).append('Please check the entry of the search field.');
                return;
            }

            $.each(json, function(i, entry) {
                var $box = $('<a class="product-box" href="#" data-id="' + entry.id + '"/>'),
                    boxString ='';

                boxString += '<div class="product">';
                boxString += '<div class="img" style="background-image: url('+ entry.image +');"></div>';
                boxString += '<div class="c">';
                boxString += '<strong>'+ entry.title +'</strong>';
                boxString += '<em>'+ entry.price +' '+ entry.currency +'</em>';
                boxString += '<small>@'+ entry.feed +'</small>';
                boxString += '</div>';
                boxString += '</div>';

                $box.html(boxString);

                $dlmImages.append($box);


                $box.append('<br></div></div></div>');

                $dlmImages.append($box);
            });

            $('div.error-dlm', jqContext).html('');
        })
    });

    $dlmImages.off('click.chooseProduct', 'a.product-box').on('click.chooseProduct', 'a.product-box', function(e){
        e.preventDefault();

        var $a = $(this),
            id = $a.data('id');

        passed_arguments.editor.selection.setContent('[product id="' + id + '"]');
        passed_arguments.editor.windowManager.close();
    });
</script>
</body>
<style type='text/css'>
    body {
        background-color: #f4f4f4;
        margin: 16px;
        color: #444;
        font-family: "Open Sans",sans-serif;
        font-size: 13px;
        line-height: 1.4em;
        -webkit-font-smoothing: subpixel-antialiased;
    }

    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    a.product-box {
        text-decoration: none;
        color: black;
    }

    .product {
        background: #f4f4f4;
        width: 300px;
        margin: 0 auto;
        padding: 20px;
    }

    .product {
        background: #fff;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.25);
    }

    .product .img {
        background: no-repeat center top;
        background-size: contain;
        height: 180px;
        margin-bottom: 20px;
    }

    .product .c {
        line-height: 1.3;
        overflow: hidden;
    }

    .product .c > * {
        display: block;
    }

    .product .c em,
    .product .c small {
        padding-top: 4px;
        color: #888;
        font-size: 0.9em;
    }

    .product .c em {
        float: left;
        font-style: normal;
    }

    .product .c small {
        float: right;
    }

    div.error-dlm {
        color: red;
    }

    input[type="text"] {
        padding: 3px 8px;
        font-size: 1.6em;
        line-height: 100%;
        height: 1.6em;
        max-width: 100%;
        width: 100%;
        outline: 0;
        margin: 0 0 3px;
        background-color: #fff;
    }

    input[type="submit"] {
        display: inline-block;
        text-decoration: none;
        font-size: 13px;
        line-height: 26px;
        height: 28px;
        margin: 0;
        padding: 0 10px 1px;
        cursor: pointer;
        border-width: 1px;
        border-style: solid;
        -webkit-appearance: none;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        white-space: nowrap;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;

        color: #555;
        border-color: #ccc;
        background: #f7f7f7;
        -webkit-box-shadow: 0 1px 0 #ccc;
        box-shadow: 0 1px 0 #ccc;
        vertical-align: top;

        background: #0085ba;
        border-color: #0073aa #006799 #006799;
        -webkit-box-shadow: 0 1px 0 #006799;
        box-shadow: 0 1px 0 #006799;
        color: #fff;
        text-decoration: none;
        text-shadow: 0 -1px 1px #006799,1px 0 1px #006799,0 1px 1px #006799,-1px 0 1px #006799;
    }
</style>
</html>