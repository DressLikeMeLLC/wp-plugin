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
<div class="images-dlm"></div>

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
        if(!json || !json.length) {
            $('div.error-dlm', jqContext).append('Please update the settings of your DressLikeMe plugin.');
            return;
        }

        $.each(json, function(i, entry) {
            var $box = $('<a class="outfit-box" href="#" data-sid="' + entry.sid + '" />'),
                date = new Date(entry.created_at * 1000);

            $box.append('<div class="outfits"><div class="outfit"><div class="img" style="background-image: url('+ entry.picture +');"></div><div class="c"><strong>'+ entry.sid +'</strong><br><em>'+ date.toDateString() +'</em></div></div></div>');

            $dlmImages.append($box);
        });
    });

    $dlmImages.off('click.chooseProduct', 'a.product').on('click.chooseProduct', 'a.product', function(e){
        e.preventDefault();

        var $a = $(this),
            sid = $a.data('sid');

        passed_arguments.editor.selection.setContent('[outfit id="' + sid + '"]');
        passed_arguments.editor.windowManager.close();
    });
</script>

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
        padding: 10px;
    }

    .outfits {
        background: #f4f4f4;
        width: 300px;
        margin: 0 auto;
    }

    .outfits .outfit {
        background: #fff;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.25);
        margin: 0 0 10px;
    }

    .outfits .outfit .img {
        background: no-repeat center top;
        background-size: contain;
        height: 180px;
    }

    .outfits .outfit .c {
        padding: 12px 15px;
        line-height: 1.3;
        overflow: hidden;
    }

    .outfits .outfit .c > * {
        display: block;
    }

    .outfits .outfit .c em,
    .outfits .outfit .c small {
        padding-top: 4px;
        color: #888;
        font-size: 0.9em;
    }

    .outfits .outfit .c em {
        float: left;
        font-style: normal;
    }

    .outfits .outfit .c small {
        float: right;
    }

    div.error-dlm {
        color: red;
    }
</style>
</body>
</html>