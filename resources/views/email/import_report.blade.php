<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Color Elephant Contract Import Report</title>
    <style type="text/css">
        .container {
            max-width: 600px !important;
        }

        #contracts {
            background-color: #eee;
            border-top: 2px solid #ccc;
            border-bottom: 2px solid #ccc;
            padding: 10px;
        }

        html,
        * {
            font-family: 'Avenir LT Std', Helvetica !important;
        }
    </style>
</head>

<body>
    Hi there,
    <br /><br />
    Your last contract upload has been completed.
    <br /><br />

    @if($report['has_successfuls'])
    Highlighted below is the list of
    contracts that were successfully
    uploaded. <br />

    <div id="contracts">
        {{ $report['successful']}}
    </div> <br /><br />
    @endif

    @if($report['has_failures'])
    Highlighted below is the list of
    contracts that already exist and were not uploaded.
    <br />

    <div id="contracts">
        {{ $report['failed']}}
    </div><br /><br />
    @endif
    
    Cheers.
</body>

</html>