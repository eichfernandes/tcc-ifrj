<?php
    if(empty($id)){
        header('Location: index.php'); exit();
    };
    
    $iduser = $_SESSION['id_usuario'];
    
    $query = "select * from notas where id_filme=$id and id_usuario=$iduser";
    $result = mysqli_query($mysqli, $query);
    $valid = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $mynota = 0;
    if($valid == 1){
        $mynota = $row['nota'];
    };
?>
<style>
    .star text{
        color: rgb(255, 255, 255, 0.2); font-size: 50px; display: inline-block;
    }
    <?php $x=0; while($x<$mynota){$x=$x+1; ?>#s<?php echo $x; ?>{color: rgb(51, 153, 102, 1); font-size: 50px; display: inline-block;} <?php }; ?>
    #star1:hover #s1{color: rgb(255, 255, 255, 1); cursor: pointer;}
    #star2:hover #s2{color: rgb(255, 255, 255, 1); cursor: pointer;}
    #star3:hover #s3{color: rgb(255, 255, 255, 1); cursor: pointer;}
    #star4:hover #s4{color: rgb(255, 255, 255, 1); cursor: pointer;}
    #star5:hover #s5{color: rgb(255, 255, 255, 1); cursor: pointer;}
</style>



<a class="tag" style="font-size: 46px; padding-right: 10px; padding-left: 10px;"><text style="word-spacing: -8px; display: inline-block;">
<span id="star1" class="star"><text id="s1" onclick="document.forms.nota1.submit();">★</text>
<span id="star2" class="star"><text id="s2" onclick="document.forms.nota2.submit();">★</text>
<span id="star3" class="star"><text id="s3" onclick="document.forms.nota3.submit();">★</text>
<span id="star4" class="star"><text id="s4" onclick="document.forms.nota4.submit();">★</text>
<span id="star5" class="star"><text id="s5" onclick="document.forms.nota5.submit();">★</text>
</span></span></span></span></span>
</text></a>

<form name="nota1" method="post" action="nota.php"><input name="nota" type="hidden" value="1"><input name="idfil" type="hidden" value="<?php echo $id; ?>"></form>
<form name="nota2" method="post" action="nota.php"><input name="nota" type="hidden" value="2"><input name="idfil" type="hidden" value="<?php echo $id; ?>"></form>
<form name="nota3" method="post" action="nota.php"><input name="nota" type="hidden" value="3"><input name="idfil" type="hidden" value="<?php echo $id; ?>"></form>
<form name="nota4" method="post" action="nota.php"><input name="nota" type="hidden" value="4"><input name="idfil" type="hidden" value="<?php echo $id; ?>"></form>
<form name="nota5" method="post" action="nota.php"><input name="nota" type="hidden" value="5"><input name="idfil" type="hidden" value="<?php echo $id; ?>"></form>

