<!DOCTYPE html>
<html>
<head>
    <!-- Disable browser caching of dialog window -->
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />
    <link rel="stylesheet" id="open-sans-css" href="https://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&amp;subset=latin%2Clatin-ext&amp;ver=4.5.2" type="text/css" media="all">
</head>
<body>
    <form>
        <label for="limit">Limit*</label><br />
        <input type="number" min="0" max="99999999" step="1" value="24" name="limit" id="limit" /><br><br>
        <input type="submit" value="Insert Wardrobe" />
    </form>
    <br>
    <p>*Fill in 0 for the whole wardrobe.</p>

    <script type="text/javascript">
        var passed_arguments = top.tinymce.activeEditor.windowManager.getParams();

        var $ = passed_arguments.jquery;
        $("input[name='limit']").focus();

        var jq_context = document.getElementsByTagName("body")[0];

        $("form", jq_context).submit(function(event) {
            event.preventDefault();

            var input_text = parseInt($("input[name='limit']", jq_context).val(), 10),
                shortcode = '[wardrobe';

            shortcode += ' limit=' + input_text + '';

            shortcode += ']';

            passed_arguments.editor.selection.setContent(shortcode);
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

        input[type="text"],
        input[type="number"] {
            padding: 3px 8px;
            font-size: 1.6em;
            line-height: 100%;
            height: 1.6em;
            max-width: 100%;
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
</body>
</html>