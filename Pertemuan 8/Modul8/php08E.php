<!DOCTYPE html>
<html lang='en-GB'>
    <head>
        <title>PHP 08E</title>
        <META name="description" content="php08E.php">
    </head>

    <body>
        <h1>Variable-length Argument Lists</h1>
        <?php
            function reduceOp() {
                $argumen = func_get_args();
                if(count($argumen) > 0 && is_array($argumen[count($argumen) - 1]) && array_key_exists('op',$argumen[count($argumen)-1]))
                {
                    $op = $argumen[count($argumen) - 1]['op'];

                    if(!in_array($op,['+', '-', '*'])){
                        throw new Exception('ValueError');
                    }
                    array_pop($argumen);
                } else{
                    throw new Exception('TypeError');
                }

                if(count($argumen) == 0){
                    return null;
                }
                else{
                    switch($op){
                    case'+':
                        return array_reduce($argumen, function($carry, $item){
                            return $carry + $item;
                        });
                    case '-':
                        $result = $argumen[0];
                        for ($i = 1; $i < count($argumen);  $i++){
                            $result = $argumen[$i];
                        }
                        return $result;
                    case '*':
                        return array_reduce($argumen, function($carry, $item) {
                            return $carry * $item;
                        }, 1);
                    }
                }
            }
            try {
                echo "1: ", reduceOp(2,3), "<br>\n"; # throws an exception
            }
            catch (Exception $e) {
                echo "1: Exception ",$e->getMessage(),"<br>\n"; # 'TypeError'
            }
            
            try {
                echo "2: ",reduceOp(2,3,array('op' => '/')), # throws an exception
                "<br>\n";
            }
            catch (Exception $e) {
                echo "2: Exception ",$e->getMessage(),"<br>\n"; # 'ValueError'
            }

            echo "3: ",reduceOp(array('op'=>'+')), # should return NULL
            "<br>\n";
            echo "4: ",reduceOp(2,array('op' => '*')), # should return 2
            "<br>\n";
            echo "5: ",reduceOp(2,3,5,array('op' => '+')), # should return 10
            "<br>\n";
            echo "6: ",reduceOp(2,3,5,7,array('op' => '*')), # should return 210
            "<br>\n";
            echo "7: ",reduceOp(2,3,5,7,11,array('op' => '-')),# should return -24
            "<br>\n";
            ?>
    </body>
</html>