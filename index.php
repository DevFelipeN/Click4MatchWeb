<html>
<body>
    <?php
        session_start();
        $_SESSION = array();
        session_destroy();
        $pontos[0] = array(242, 318, 200, 275, 'AD');
        $pontos[1] = array(334, 407, 200, 275, 'SU');
        $pontos[2] = array(242, 318, 286, 360, 'MU');
        $pontos[3] = array(334, 407, 286, 360, 'DI'); 
    ?>
    <?php
            for ($i=0; $i< 4; $i++){
        ?>
        <input type='hidden' id='x_ini_<?= $i ?>' value='<?php echo $pontos [$i]  [0] ?>'/>
        <input type='hidden' id='x_fin_<?= $i ?>' value='<?php echo $pontos [$i]  [1] ?>'/>
        <input type='hidden' id='y_ini_<?= $i ?>' value='<?php echo $pontos [$i]  [2] ?>'/>
        <input type='hidden' id='y_fin_<?= $i ?>' value='<?php echo $pontos [$i]  [3] ?>'/>
        <input type='hidden' id='op_<?= $i ?>' value='<?php echo $pontos [$i]  [4] ?>'/>
        <?php
            }
        ?>
    <script>
        function botao_clik(event){
            for(i=0; i < 4; i++){
                x1 =document.getElementById('x_ini_' + i);
                x2=document.getElementById('x_fin_' + i);
                y1 =document.getElementById('y_ini_' + i);
                y2=document.getElementById('y_fin_' + i);
                z1=document.getElementById('z_num_' + i);
                op=document.getElementById('op_' + i);
                valor1 = Number.parseInt(x1.value);
                valor2 = Number.parseInt(x2.value);
                valor3 = Number.parseInt(y1.value);
                valor4 = Number.parseInt(y2.value);
                var xCoordinate = event.offsetX;
                var yCoordinate = event.offsetY;
                if (xCoordinate >= valor1 &&  xCoordinate <= valor2 && yCoordinate >= valor3 && yCoordinate <= valor4) {
                   document.getElementById('op').value = op.value;
                   document.getElementById('form_op').submit();
                }
               
            }
        }
        function alterar(event, element){
			
            for(i=0; i < 4; i++){
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
    </script>
        <center><h1>Escolha a operação e resolva os desafios</h1></center>
        <center><form id='form_op' action="figura.php" method="POST">
            <input type='hidden' name="op" id='op' />
            <input type='hidden' name=pontuacao value=0 />
        </form></center>
        <center><img src='tela.png' onclick='botao_clik(event)' onmousemove="alterar(event, this)" /></center>
        <center><form action="Inform.php" method="POST">
            <input type="submit" value="Info"/>
        </form></center>
</body>
</html>
