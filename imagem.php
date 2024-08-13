<?php
    $oper= $_GET['oper'];
    $fase= $_GET['fase'];
    if ($fase <= 12){
        $imagem = ImageCreateFromPNG($oper."/".$fase.".png");
        $cor = imagecolorallocate($imagem, 0, 0, 0);
        $b1 = $_GET['b1'];
        $b2 = $_GET['b2'];
        $b3 = $_GET['b3'];
        $b4 = $_GET['b4'];
        $b5 = $_GET['b5'];
        $op1= $_GET['op1'];
        $op2= $_GET['op2'];
        $r= $_GET['r'];
        $x1 = $_GET['x1'];
        $y1 = $_GET['y1'];
        $x2 = $_GET['x2'];
        $y2 = $_GET['y2'];
        $x3 = $_GET['x3'];
        $y3 = $_GET['y3'];
        $x4 = $_GET['x4'];
        $y4 = $_GET['y4'];
        $x5 = $_GET['x5'];
        $y5 = $_GET['y5'];
        $x6 = $_GET['x6'];
        $y6 = $_GET['y6'];
        $x7 = $_GET['x7'];
        $y7 = $_GET['y7'];
        $x8 = $_GET['x8'];
        $y8 = $_GET['y8'];
        imagettftext($imagem, 20, 0, $x1, $y1, $cor, "./arial.ttf", $b1);
        imagettftext($imagem, 20, 0, $x2, $y2, $cor, "./arial.ttf", $b2);
        imagettftext($imagem, 20, 0, $x3, $y3, $cor, "./arial.ttf", $b3);
        imagettftext($imagem, 20, 0, $x4, $y4, $cor, "./arial.ttf", $b4);
        imagettftext($imagem, 20, 0, $x5, $y5, $cor, "./arial.ttf", $b5);
        imagettftext($imagem, 60, 0, $x6, $y6, $cor, "./arial.ttf", $op1);
        imagettftext($imagem, 60, 0, $x7, $y7, $cor, "./arial.ttf", $op2);
        imagettftext($imagem, 60, 0, $x8, $y8, $cor, "./arial.ttf", $r);
        header('Content-type: image/png');
        imagepng($imagem);
        imagedestroy($imagem);
    }else{
        //implementar o retorno da imagem correspondente do certificado
        $imagem = ImageCreateFromPNG($oper."/".$fase.".png");
        $cor = imagecolorallocate($imagem, 0, 0, 0);
        $ponto= $_GET['ponto'];
        $c1 = $_GET['c1'];
        $c2 = $_GET['c2'];
        $idem = $_GET['idem'];
        $x = $_GET['x'];
        $y = $_GET['y'];
        $x1 = $_GET['x1'];
        $y1 = $_GET['y1'];
        $x2 = $_GET['x2'];
        $y2 = $_GET['y2'];
        $x3 = $_GET['x3'];
        $y3 = $_GET['y3'];
        imagettftext($imagem, 20, 0, $x, $y, $cor, "./arial.ttf", $ponto);
        imagettftext($imagem, 20, 0, $x1, $y1, $cor, "./arial.ttf", $c1);
        imagettftext($imagem, 20, 0, $x2, $y2, $cor, "./arial.ttf", $c2);
        imagettftext($imagem, 20, 0, $x3, $y3, $cor, "./arial.ttf", $idem);
        header('Content-type: image/png');
        imagepng($imagem);
        imagedestroy($imagem);
    }
?>

