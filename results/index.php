<?
    function tally_votes($fileName, $graphTitle){
        include "../info.php";

        $contents = file_get_contents("../" . $fileName . ".txt");
        $votes = array();
        foreach(split("\n", $contents) as $line){
            if($line != ""){
                $split = split(":", $line);
                $votes[$split[0]] = $split[1];
            }
        }
        $votesRemaining = count($names) - count($votes);
        $maxVoteScore = count($names) - 1;
        $scores = array();
        foreach($names as $name){
            $scores[$name] = 0;
        }
        ?>
            <style>
                body * {
                    font-family: Helvetica;
                }
                .score-bar {
                    display: block;
                    background: lightblue;
                    height: 20px;
                    padding: 10px;
                }
                .graph-header td {
                    text-align: center;
                }
            </style>
            <div class="results">
                <h2><? echo $graphTitle; ?></h2>
                <? if($votesRemaining > 0){ ?>
                    Cannot display results until all votes are cast. Still waiting on <? echo $votesRemaining; ?> people to cast their vote.
                <? } else { ?>
                    <table>
                        <tr class='graph-header'><td><h3>Pledge</h3></td><td><h3>Score</h3></td></tr>
                        <?
                            foreach($votes as $vote){
                                $score = $maxVoteScore;
                                foreach(split(",", $vote) as $name){
                                    if($name != ""){
                                        $scores[$name] += $score;
                                        $score--;
                                    }
                                }
                            }

                            arsort($scores);
                            foreach($scores as $name => $score){
                                ?>
                                    <tr>
                                        <td><? echo $name; ?></td>
                                        <td><div class="score-bar" style="width: <? echo $score * 16; ?>px;"><? echo $score; ?></div></td>
                                    </tr>
                                <?
                            }
                        ?>
                    </table>
                <? } ?>
            </div>
        <?

    }

    tally_votes("president", "Pledge Class President");
    tally_votes("social", "Pledge Class Social Chair");
?>