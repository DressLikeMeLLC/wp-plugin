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
        dlmTranslations = passed_arguments.dlmTranslations,
        ajaxurl = passed_arguments.ajaxurl,
        $ = passed_arguments.jquery,
        jqContext = document.getElementsByTagName("body")[0],
        $dlmImages = $('div.images-dlm', jqContext);

    $.post(ajaxurl, {
        action: 'dlm_check_api_action'
    }, function(data) {
        var json = $.parseJSON(data);
        if(!json['success']) {
            $('div.error-dlm', jqContext).append(dlmTranslations.plchset);
            $('div.error-dlm', jqContext).append('<br>');
            $('div.error-dlm', jqContext).append('<a href="/wp-admin/admin.php?page=dlm" target="_blank" class="button-primary">'+ dlmTranslations.yourset +'</a>');
            return;
        }

        $.post(ajaxurl, {
            action: 'dlm_json_action'
        }, function(data) {
            var json = $.parseJSON(data);
            if(!json || !json.length) {
                $('div.error-dlm', jqContext).append(dlmTranslations.nooutfit);
                return;
            }

            $.each(json, function(i, entry) {
                var $box = $('<a class="outfit-box" href="#" data-sid="' + entry.sid + '" />'),
                    date = new Date(entry.created_at * 1000),
                    boxString ='';

                boxString += '<div class="outfit">';
                boxString += '<div class="img" style="background-image: url('+ entry.picture +');"></div>';
                boxString += '<div class="c">';
                boxString += '<strong>'+ entry.sid +'</strong>';
                boxString += '<small>'+ date.toDateString() +'</small>';
                boxString += '</div>';
                boxString += '</div>';

                $box.html(boxString);

                $dlmImages.append($box);
            });
        });
    });

    $dlmImages.off('click.chooseProduct', 'a.outfit-box').on('click.chooseProduct', 'a.outfit-box', function(e){
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

    .images-dlm {
        margin: 0 -10px;
    }

    a.button-primary {

    }

    a.outfit-box {
        width: 33.3333%;
        color: black;
        text-decoration: none;
        float: left;
        padding: 10px;
    }

    @media (min-width: 601px) {
        a.outfit-box {
            width: 33.3%;
        }
    }

    @media (max-width: 600px) {
        a.outfit-box {
            width: 100%;
        }
    }

    .outfit {
        background: #fff;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.25);
        margin: 0 0 10px;
    }

    .outfit .img {
        background: no-repeat center top;
        background-size: cover;
        height: 260px;
    }

    .outfit .c {
        padding: 12px 15px;
        line-height: 1.3;
        overflow: hidden;
        text-align: center;
    }

    .outfit .c > * {
        display: block;
    }

    .outfit .c small {
        padding-top: 4px;
        color: #888;
        font-size: 0.9em;
    }

    .outfit .c strong {

    }

    div.error-dlm {
        color: red;
    }

    div.success-dlm {}
</style>
</body>
</html>