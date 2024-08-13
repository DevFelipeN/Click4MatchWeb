<?php
    if (!isset($_POST["op"])){
        header('Location: index.php');
        die();
    }
    session_start();
    if (isset($_POST["figura"])){
        if (isset($_SESSION["fase"]) and $_POST["figura"] < $_SESSION["fase"]){
            header('Location: index.php');
        }
    }
?>

<html>
<head>
    <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        //este metodo aleatoriamente gera dois operandos e um resultado para a operacao de soma
        function gerar_aleatorios_soma($limite){
            $vetor = array();
            $op1 = random_int(0,$limite);
            $op2 = random_int(0,$limite-$op1);
            $resultado = $op1 + $op2;
            $vetor[] = $op1;
            $vetor[] = $op2;
            $vetor[] = $resultado;
            return $vetor;
        }

        function gerar_aleatorios_subtracao($limite){
            $vetor = array();
            $op1 = random_int(0,$limite);
            $op2 = random_int(0,$limite-$op1);
            if ($op1 < $op2){
                $aux = $op1;
                $op1 = $op2;
                $op2 = $aux;
            }
            $resultado = $op1 - $op2;
            $vetor[] = $op1;
            $vetor[] = $op2;
            $vetor[] = $resultado;
            return $vetor;
        }

        function gerar_aleatorios_multiplicacao($limite){
            $vetor = array();
            $resultado = random_int(1,$limite);
            $divisores = array();
            $divisor = $resultado;
            while ( $divisor >= 1 ){
                if ( $resultado % $divisor == 0){
                    $divisores[]=$divisor;
                }
                $divisor--;
            }
            $contador=count($divisores)-1;
            $aux =  random_int(0,$contador);
            $op1 = $divisores[$aux];
            $op2 = $resultado / $op1;
            $vetor[] = $op1;
            $vetor[] = $op2;
            $vetor[] = $resultado;
            return $vetor;
        }
        function gerar_aleatorios_divisao($limite){
            $vetor = array();
            $op1 = random_int(1,$limite);
            $divisores = array();
            $divisor = $op1;
            while ( $divisor >= 1 ){
                if ($op1 % $divisor == 0){
                    $divisores[] = $divisor;
                }
                $divisor--;
            }
            $aux =  random_int(0,count($divisores)-1);
            $op2 = $divisores[$aux];
            $resultado = $op1 / $op2;
            $vetor[] = $op1;
            $vetor[] = $op2;
            $vetor[] = $resultado;
            return $vetor;
        }

        $operacao = "ER";
               
        $contador = 0;
        $imagem = "";
        $resultado = 0;
        $pontuacao =0;
        if (isset($_POST["op"]) && ($_POST["op"] == "AD" || $_POST["op"] == "SU" || $_POST["op"] == "MU" || $_POST["op"] == "DI")){
            $operacao = $_POST["op"]; 
            $pontuacao = $_POST["pontuacao"];
            if (isset($_POST["botaocalcular"]) && $_POST["botaocalcular"] == 'Calcular'){
                //entra aqui se o botao Calcular foi clicado
                $v1 = $_POST["valor1"];
                $v2 = $_POST["valor2"];
                $la = $_POST["lacuna"];
                $re = $_POST["resultado"];
                $la1 = $_POST["op1"];
                $la2 = $_POST["op2"];
                if(($v1 == $re && $la == 0) || ($v1 == $la2 && $la == 1) || ($v1 == $la1 && $la == 2) || ($la == 3 && (($v1 + $v2 == $re && $operacao == "AD") || ($v1 - $v2 == $re && $operacao == "SU") || ($v1 * $v2 == $re && $operacao == "MU") || ($v2 != 0 && $v1 / $v2 == $re && $operacao == "DI"))))  {
                    $pontuacao += 1;
                }
            }
            if(isset($_POST["figura"])){
                $imagem = $_POST["figura"] + 1;
            }else{
                $imagem = 1;
            }
            if ($imagem <= 12){
                $caminho_txt = $operacao."/".$imagem.".txt";
                $file = fopen($caminho_txt,"r");
                $linha1 = fgetcsv($file);
                $linha2 = fgetcsv($file);
                $linha3 = fgetcsv($file);
                $linha4 = fgetcsv($file);
                $linha5 = fgetcsv($file);
                fclose($file);
                $lacuna = ($imagem - 1) % 4;
                if ($imagem <= 4){
                    $limite=10;
                }else if ($imagem <= 8){
                    $limite=20;
                }else if ($imagem <= 12){
                    $limite=30;
                }


                $pontos = array();
                $possiveis = array();
                if ($operacao == "AD"){ $aux = gerar_aleatorios_soma($limite);
                }else if ($operacao == "SU"){$aux = gerar_aleatorios_subtracao($limite);
                }else if ($operacao == "MU"){$aux = gerar_aleatorios_multiplicacao($limite);
                }else if($operacao == "DI"){ $aux = gerar_aleatorios_divisao($limite);
                }

                $op1 = $aux[0];
                $op2 = $aux[1];
                $r = $aux[2];
                if ($lacuna == 0){
                    $possiveis[] = $r;
                }else if ($lacuna == 1){
                    $possiveis[] = $op2;
                }else if ($lacuna == 2){
                    $possiveis[] = $op1;
                }else{
                    $possiveis[] = $op1;
                    $possiveis[] = $op2;
                }
                $aux = range(0,$limite);
                shuffle($aux);
                $cont=count($possiveis);
                $i=0;
                while ($cont < 5){
                    if (in_array($aux[$i],$possiveis) == FALSE){
                        $possiveis[] = $aux[$i];
                        $cont++;
                    }
                    $i++;
                }
                shuffle($possiveis);

                $pontos[0] = array(trim($linha1[0]), trim($linha1[1]), trim($linha1[2]), trim($linha1[3]),  $possiveis[0]);
                $pontos[1] = array(trim($linha2[0]), trim($linha2[1]), trim($linha2[2]), trim($linha2[3]),  $possiveis[1]);
                $pontos[2] = array(trim($linha3[0]), trim($linha3[1]), trim($linha3[2]), trim($linha3[3]),  $possiveis[2]);
                $pontos[3] = array(trim($linha4[0]), trim($linha4[1]), trim($linha4[2]), trim($linha4[3]),  $possiveis[3]);
                $pontos[4] = array(trim($linha5[0]), trim($linha5[1]), trim($linha5[2]), trim($linha5[3]),  $possiveis[4]);
                $resultado = $r;
                $contador =  count($pontos);
            }
        }  
        
    ?>
    <?php
    if ($imagem <=12){
        $_SESSION["fase"] = $imagem;
    ?>
    <script>
        function imagem_clicada(event){
            var lacuna = document.getElementById('lacuna').value;
            for(i=0; i < <?= $contador ?>; i++){
                x1 =document.getElementById('x_ini_' + i);
                x2=document.getElementById('x_fin_' + i);
                y1 =document.getElementById('y_ini_' + i);
                y2=document.getElementById('y_fin_' + i);
                z1=document.getElementById('z_num_' + i);
                c1 = document.getElementById('clique1');
                c2 = document.getElementById('clique2');
                valor1 = Number.parseInt(x1.value);
                valor2 = Number.parseInt(x2.value);
                valor3 = Number.parseInt(y1.value);
                valor4 = Number.parseInt(y2.value);
                bolinha = Number.parseInt(z1.value);
                var xCoordinate = event.offsetX;
                var yCoordinate = event.offsetY;
                if (xCoordinate >= valor1 &&  xCoordinate <= valor2 && yCoordinate >= valor3 && yCoordinate <= valor4) {
                    if (c1.value == ''){
                        c1.value = bolinha;
                    }else if (lacuna == 3 && c2.value == ''){
                        c2.value = bolinha;
                    }
                    if (lacuna == 0){
                        codigo = 3;
				        valor = c1.value;
                        document.getElementById('msg' + codigo).innerHTML = valor;
                    }else if (lacuna == 1){
                        codigo = 2;
				        valor = c1.value;
                        document.getElementById('msg' + codigo).innerHTML = valor;
                    }else if (lacuna == 2){
                        codigo = 1;
				        valor = c1.value;
                        document.getElementById('msg' + codigo).innerHTML = valor;
                    }else if (lacuna == 3){
                        codigo = 1;
                        codigo1 = 2;
                        valor = c1.value;
                        valory = c2.value;
                        document.getElementById('msg' + codigo).innerHTML = valor;
                        document.getElementById('msg' + codigo1).innerHTML = valory;
                    }
                }
               
            }
        }
        function alterar(event, element){
			
            for(i=0; i < <?= $contador ?>; i++){
                x1 =document.getElementById('x_ini_' + i);
                x2=document.getElementById('x_fin_' + i);
                y1 =document.getElementById('y_ini_' + i);
                y2=document.getElementById('y_fin_' + i);
                valor1 = Number.parseInt(x1.value);
                valor2 = Number.parseInt(x2.value);
                valor3 = Number.parseInt(y1.value);
                valor4 = Number.parseInt(y2.value);
                var xCoordinate = event.offsetX;
                var yCoordinate = event.offsetY;
			   
               if ((xCoordinate >= valor1) && ( xCoordinate <= valor2) && (yCoordinate >= valor3) && (yCoordinate <= valor4)) {	
					element.style.cursor = "pointer";
                     break;
			   }else{
					element.style.cursor = "auto";
			   }
            } 
            
        }
        function verificar_result(){
            var lacuna = document.getElementById('lacuna').value;
            c1 =document.getElementById('clique1');
            c2=document.getElementById('clique2');
            n1 = Number.parseInt(c1.value);
            n2 = Number.parseInt(c2.value);
            if ((n1 == <?= $r ?> && lacuna == 0) || (n1 == <?= $op2 ?> && lacuna == 1) || (n1 == <?= $op1 ?> && lacuna == 2) || (lacuna == 3 && n1 + n2 == <?= $r ?>  )|| (lacuna == 3 && n1 - n2 == <?= $r ?>  )|| (lacuna == 3 && n1 * n2 == <?= $r ?>  ) || (lacuna == 3 && n1 / n2 == <?= $r ?>  ) ){
                alert("CORRETO");
            }else{
                alert("INCORRETO")
            }
            <?php if ($imagem == 12){ ?>
                textodigitado = prompt('Digite seu nome');
                document.getElementById('nome').value = textodigitado;
        <?php } ?>
        }
        function camp_limp(){
            document.getElementById('clique1').value='';
            document.getElementById('clique2').value='';
            document.getElementById('msg' + codigo).innerHTML = '';
            document.getElementById('msg' + codigo1).innerHTML = '';
           
        }
    </script>
        <style>
		#container {
			display: inline-block;
			position: relative;
		}

		#container span#msg1 {
			position: absolute;
			top: 390px;
			right: 520px;
			font-size: 80px;
			color: black;
		}
		
		#container span#msg2 {
			position: absolute;
			top: 390px;
			right: 340px;
			font-size: 80px;
			color: black;
		}
		
		#container span#msg3 {
			position: absolute;
			top: 390px;
			right: 140px;
			font-size: 80px;
			color: black;
		}
        </style>
</head>
<body bgcolor="orange">
    <?php
    if ($operacao == "ER"){
        echo "OPERACAO INDEFINIDA";
    }
    //echo($caminho_txt);
    //var_dump($pontos);
    ?>
    <?php if ($operacao =="AD"){ ?>
    <center><h1><font color="blue">Mundo da Adição</font></h1></center>
    <?php } else if ($operacao == "MU") { ?>
        <center><h1><font color="green">Mundo da Multiplicação</h1></center></font></h1></center>
    <?php } else if ($operacao == "SU"){ ?>
        <center><h1><font color="red">Mundo da Subtração</font></h1></center>
    <?php } else if ($operacao == "DI") {  ?>
        <center><h1><font color="purple">Mundo da Divisão</font></h1></center>
    <?php } ?>
    <?php
        for ($i=0; $i< $contador; $i++){
    ?>
            <input type='hidden' id='x_ini_<?= $i ?>' value='<?php echo $pontos [$i]  [0] ?>'/>
            <input type='hidden' id='x_fin_<?= $i ?>' value='<?php echo $pontos [$i]  [1] ?>'/>
            <input type='hidden' id='y_ini_<?= $i ?>' value='<?php echo $pontos [$i]  [2] ?>'/>
            <input type='hidden' id='y_fin_<?= $i ?>' value='<?php echo $pontos [$i]  [3] ?>'/>
            <input type='hidden' id='z_num_<?= $i ?>' value='<?php echo $pontos [$i]  [4] ?>'/>

        <?php
        }
        ?>
        <form action='figura.php' method='POST'>
            <input type='hidden' name='op' value='<?= $operacao ?>'/>
            <input type='hidden' name='valor1' id='clique1'/>
            <input type='hidden' name='valor2' id='clique2'/>
            <input type='hidden' name='nome' id='nome'/>
            <input style='background-color: yellow' type='hidden' id='resultado' name='resultado' value='<?php echo $resultado ?>'/>
            <input style='background-color: yellow' type='hidden' id='op1' name='op1' value='<?php echo $op1 ?>'/>
            <input style='background-color: yellow' type='hidden' id='op2' name='op2' value='<?php echo $op2 ?>'/>
            <input style='background-color: yellow' type='hidden' id='lacuna' name='lacuna' value='<?php echo $lacuna ?>'/>
            <center>Fase: <input type='text' id='figura' name='figura' value='<?php echo $imagem ?>' size='2' readonly/>/12</center>
            <center>Pontos: <input type='text'  id= 'pontuacao' name='pontuacao' value= '<?php echo $pontuacao ?>' size='2' readonly/></center>
           
        
        <?php
        if ($lacuna == 0){
        ?>
            <center>
            <figure id="container">
            <img src='imagem.php?oper=<?php echo $operacao?>&fase=<?php echo $imagem?>&b1=<?php echo $possiveis[0] ?>&x1=<?php echo $pontos[0][0]+10 ?>&y1=<?php echo $pontos[0][3]-10 ?>&b2=<?php echo $possiveis[1] ?>&x2=<?php echo $pontos[1][0]+10 ?>&y2=<?php echo $pontos[1][3]-10 ?>&b3=<?php echo $possiveis[2] ?>&x3=<?php echo $pontos[2][0]+10 ?>&y3=<?php echo $pontos[2][3]-10 ?>&b4=<?php echo $possiveis[3] ?>&x4=<?php echo $pontos[3][0]+10 ?>&y4=<?php echo $pontos[3][3]-10 ?>&b5=<?php echo $possiveis[4] ?>&x5=<?php echo $pontos[4][0]+10 ?>&y5=<?php echo $pontos[4][3]-10 ?>&op1=<?php echo $op1 ?>&x6=56&y6=463&op2=<?php echo $op2 ?>&x7=238&y7=463&x7=238&y7=463' onclick='imagem_clicada(event)' ondragstart='return false' onmousemove="alterar(event, this)" />
            <span id="msg1">&nbsp;</span>
		    <span id="msg2">&nbsp;</span>
		    <span id="msg3">&nbsp;</span>
            </figure>
            </center>
            <form action='figura.php' method='POST'>
            <center><input type='submit' name='botaocalcular' value='Calcular' onclick='verificar_result()'/></center>
            <center><input type='button' value='Limpar' onclick='camp_limp()'/></center>
            </form>
        <?php
        }else if ($lacuna == 1){?>
            <center>
            <figure id="container">    
            <img src='imagem.php?oper=<?php echo $operacao?>&fase=<?php echo $imagem?>&b1=<?php echo $possiveis[0] ?>&x1=<?php echo $pontos[0][0]+10 ?>&y1=<?php echo $pontos[0][3]-10 ?>&b2=<?php echo $possiveis[1] ?>&x2=<?php echo $pontos[1][0]+10 ?>&y2=<?php echo $pontos[1][3]-10 ?>&b3=<?php echo $possiveis[2] ?>&x3=<?php echo $pontos[2][0]+10 ?>&y3=<?php echo $pontos[2][3]-10 ?>&b4=<?php echo $possiveis[3] ?>&x4=<?php echo $pontos[3][0]+10 ?>&y4=<?php echo $pontos[3][3]-10 ?>&b5=<?php echo $possiveis[4] ?>&x5=<?php echo $pontos[4][0]+10 ?>&y5=<?php echo $pontos[4][3]-10 ?>&op1=<?php echo $op1 ?>&x6=56&y6=463&r=<?php echo $r ?>&x8=430&y8=463' onclick='imagem_clicada(event) ' ondragstart='return false' onmousemove="alterar(event, this)"/>
            <span id="msg1">&nbsp;</span>
		    <span id="msg2">&nbsp;</span>
		    <span id="msg3">&nbsp;</span>
            </figure>
            </center>
            <form action='figura.php' method='POST'>
            <center><input type='submit' name='botaocalcular' value='Calcular' onclick='verificar_result()'/></center>
            <center><input type='button' value='Limpar' onclick='camp_limp()'/></center>
            </form>
        <?php 
        }else if ($lacuna == 2){?>
            <center>
            <figure id="container">
            <img src='imagem.php?oper=<?php echo $operacao?>&fase=<?php echo $imagem?>&b1=<?php echo $possiveis[0] ?>&x1=<?php echo $pontos[0][0]+10 ?>&y1=<?php echo $pontos[0][3]-10 ?>&b2=<?php echo $possiveis[1] ?>&x2=<?php echo $pontos[1][0]+10 ?>&y2=<?php echo $pontos[1][3]-10 ?>&b3=<?php echo $possiveis[2] ?>&x3=<?php echo $pontos[2][0]+10 ?>&y3=<?php echo $pontos[2][3]-10 ?>&b4=<?php echo $possiveis[3] ?>&x4=<?php echo $pontos[3][0]+10 ?>&y4=<?php echo $pontos[3][3]-10 ?>&b5=<?php echo $possiveis[4] ?>&x5=<?php echo $pontos[4][0]+10 ?>&y5=<?php echo $pontos[4][3]-10 ?>&op2=<?php echo $op2 ?>&x7=238&y7=463&r=<?php echo $r ?>&x8=430&y8=463' onclick='imagem_clicada(event) ' ondragstart='return false' onmousemove="alterar(event, this)"/>
            <span id="msg1">&nbsp;</span>
		    <span id="msg2">&nbsp;</span>
		    <span id="msg3">&nbsp;</span>
            </figure>
            </center>
            <form action='figura.php' method='POST'>
            <center><input type='submit' name='botaocalcular' value='Calcular' onclick='verificar_result()'/></center>
            <center><input type='button' value='Limpar' onclick='camp_limp()'/></center>
            </form>
        <?php
        }else if ($lacuna == 3){ ?>
            <center>
            <figure id="container">    
            <img src='imagem.php?oper=<?php echo $operacao?>&fase=<?php echo $imagem?>&b1=<?php echo $possiveis[0] ?>&x1=<?php echo $pontos[0][0]+10 ?>&y1=<?php echo $pontos[0][3]-10 ?>&b2=<?php echo $possiveis[1] ?>&x2=<?php echo $pontos[1][0]+10 ?>&y2=<?php echo $pontos[1][3]-10 ?>&b3=<?php echo $possiveis[2] ?>&x3=<?php echo $pontos[2][0]+10 ?>&y3=<?php echo $pontos[2][3]-10 ?>&b4=<?php echo $possiveis[3] ?>&x4=<?php echo $pontos[3][0]+10 ?>&y4=<?php echo $pontos[3][3]-10 ?>&b5=<?php echo $possiveis[4] ?>&x5=<?php echo $pontos[4][0]+10 ?>&y5=<?php echo $pontos[4][3]-10 ?>&x6=56&y6=463&r=<?php echo $r ?>&x8=430&y8=463' onclick='imagem_clicada(event) ' ondragstart='return false' onmousemove="alterar(event, this)"/>
            <span id="msg1">&nbsp;</span>
		    <span id="msg2">&nbsp;</span>
		    <span id="msg3">&nbsp;</span>
            </figure>
            </center>
            <form action='figura.php' method='POST'>
            <center><input type='submit' name='botaocalcular' value='Calcular' onclick='verificar_result()'/></center>
            <center><input type='button' value='Limpar' onclick='camp_limp()'/></center>
            </form>
        <?php
        }
        
        }else if($imagem == 13){
        $texto = $_POST['nome'] ?>
        
           
        </form>
        <center><form action="index.php" method="POST">
            <input type="submit" value="Inicio"/>
        </form></center>
    <center><img src='imagem.php?oper=<?php echo $operacao?>&fase=<?php echo $imagem?>&ponto=<?php echo $pontuacao ?>&x=360&y=250&c1=Pontuação:&x1=220&y1=250&c2=Nome:&x2=220&y2=200&idem=<?php echo $texto ?>&x3=310&y3=200'/></center>
<?php } ?>
        
</body>
</html>


