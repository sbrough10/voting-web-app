<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <style>
        body * {
            font-family: Helvetica;
            font-size: 18px;
        }
        .notification, .cast-vote-div, .office-div, .email-div {
            margin-bottom: 20px;
        }
        .notification {
            color: green;
        }
        .cast-vote-div {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }
        .office-sub-div {
            margin: 10px;
        }
        .voter {
            width: 100%;
        }
        .select {
            width: 100px;
            height: 50px;
        }
    </style>
</head>
<body>
    <div class="notification">
        <?
            include "./info.php";

            $defaultVoterOption = "-- VOTER NAME --";
            $voter = "";
            if(isset($_POST["voter"])){
                $voter = $_POST["voter"];
                $file = $_POST["office"] . ".txt";
                file_put_contents($file, file_get_contents($file) . $_POST["voter"] . ":" . $_POST["data"] . "\n");
                ?>
                    Your vote has been cast! Feel free to re-cast if you'd like to rerank the candidates.
                <?
            }
        ?>
    </div>
    <div>
        <form action='' method='post'>
            <div class='cast-vote-div'>
                <button class='cast-vote'>Cast Vote</button>
            </div>
            <div class='office-div'>
                <span class='office-header'>Office:</span><br />
                <div class='office-sub-div'><label><input type="radio" name="office" value="president"/> Pledge Class President</label></div>
                <div class='office-sub-div'><label><input type="radio" name="office" value="social"/> Pledge Class Social Chair</label></div>
            </div>
            <div class='voter-div'>
                <select class='voter' name='voter'>
                    <option><? echo $defaultVoterOption; ?></option>
                    <? foreach($names as $name){ ?>
                        <option><? echo $name; ?></option>
                    <? } ?>
                </select>
            </div>
            <input type='hidden' name='data' value='' class='data'/>
        </form>
        <? foreach($names as $name){ ?>
            <button name="<? echo $name; ?>" class='select'>Select</button> <? echo $name; ?><br />
        <? } ?>
    </div>
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script>
        var $ = jQuery;
        var selections = [];

        $(".select").click(function(){
            if(this.innerText == "Select"){
                selections.push(this);
                this.innerHTML = selections.length;
            } else {
                this.innerText = "Select";
                selections.splice(selections.indexOf(this),1);
                for(var i = 0; i < selections.length; i++){
                    selections[i].innerText = i + 1;
                }
            }

            var postData = "";
            for(var i = 0; i < selections.length; i++){
                postData += $(selections[i]).attr("name") + ",";
            }
            $(".data").attr("value", postData);
        });

        $(".cast-vote").click(function(event){
            var offices = $("[name=office]");
            var officePicked = false;
            for(var i = 0; i < offices.length; i++){
                if(offices[i].checked){
                    officePicked = true;
                }
            }
            if(!officePicked || $(".voter").val() == "<? echo $defaultVoterOption; ?>"){
                event.preventDefault();
                $(".notification").css("color", "red")
                    .text("You must select one of the offices and enter your Purdue email before casting your vote.");
            }
        });
    </script>
</body>