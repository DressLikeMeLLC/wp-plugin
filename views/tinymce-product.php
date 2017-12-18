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
<form>
    <input type="text" name="search" id="search" /><br><br>
    <input type="submit" value="Search for this product." />
</form>
<div class="images-dlm"></div>
<br>

<script>
    var passed_arguments = top.tinymce.activeEditor.windowManager.getParams(),
        ajaxurl = passed_arguments.ajaxurl,
        $ = passed_arguments.jquery,
        jqContext = document.getElementsByTagName("body")[0],
        $dlmImages = $('div.images-dlm', jqContext);

    $("form", jqContext).submit(function(event) {
        event.preventDefault();
        $.post(ajaxurl, {
            action: 'dlm_product_json_action',
            search: $("input[name='search']", jqContext).val()
        }, function(data) {
            console.log(data);
            var json = $.parseJSON(data);
            console.log(json);
            if (!json || !json.length) {
                $('div.error-dlm', jqContext).html('Please update the settings of your DressLikeMe plugin and check the entry of the search field.');
                return;
            }

            $.each(json, function(i, entry) {
                var $box = $('<a class="product" href="#" data-id="' + entry.id + '" />');
                $box.append('<p><img style="height:150px;" src="'+ entry.image +'" /></p>');
                $box.append('<p><strong>'+ entry.title +'</strong></p>');
                $box.append('<p>'+ entry.price +' '+ entry.currency +'</p>');
                $box.append('<p><small>'+ entry.id +'</small></p>');

                $dlmImages.append($box);
            });

            $('div.error-dlm', jqContext).html('');
        })
    });

    $dlmImages.off('click.chooseProduct', 'a.product').on('click.chooseProduct', 'a.product', function(e){
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

    a {
        color: black;
        text-decoration: none;
        float: left;
        padding: 20px;
    }

    input[type="text"] {
        padding: 3px 8px;
        font-size: 1.6em;
        line-height: 100%;
        height: 1.6em;
        max-width: 100%;
        width: 80%;
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