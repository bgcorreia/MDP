<?php
header('Content-type: text/json');

$json = array();

$dir_random = '../../data/' . $_REQUEST['exec']; 

// Tamanho do arquivo para upload em MB
$fileSizeMB = 20 ;

if ( !(is_dir($dir_random)) ){
  mkdir( $dir_random , 0755 );
}

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = $dir_random . '/';

// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * $fileSizeMB; // MB

// Array com as extensões permitidas
$_UP['extensoes'] = array('tsv' , 'gmt', 'zip');

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = "There wasn't any problem";
$_UP['erros'][1] = "Uploaded file is larger than the PHP limit";
$_UP['erros'][2] = "Uploaded file is larger than the limit";
$_UP['erros'][3] = "O upload do arquivo foi feito parcialmente";
$_UP['erros'][4] = "The file wasn't sent";


class mdpActions{

  function verificaExtensao($fileName, $arrayExtensoes) {

    // Caso o script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
    // Faz a verificação da extensão do arquivo
    $preextensao = explode('.', $fileName); 
    // Se fizer tudo direto o php retorna um erro
    // PHP Notice:  Only variables should be passed by reference 
    $extensao = strtolower(end($preextensao));
    if (array_search($extensao, $arrayExtensoes) === false) {
      $json['error'] = "Please, send files with the following extension(s): tsv";
      echo json_encode($json);
      exit;
    }

    return $extensao;

  }

  function verificaTamanho($tamanhoArquivo, $tamanhoMaximo) {

    // Faz a verificação do tamanho do arquivo
    if ($tamanhoArquivo > $tamanhoMaximo){
      $json['error'] = "Uploaded file is too large. The file size limit is " . $tamanhoMaximo . ".";
      echo json_encode($json);
      exit; // Para a execução do script
    }

  }

  function moveArquivo($tipo, $extensao, $origem, $dirDestino) {

    $jsonClass = array();

    switch ($tipo) {

      case "expression":

        $nome_final = 'edata.tsv';
        $nome_final_zip = 'edata.zip';
      
      break;

      case "phenotypic":

        $nome_final = 'pdata.tsv';
      
      break;

      case "gmt":

        $nome_final = 'pathways.gmt';
      
      break;

    }

    switch ($extensao) {

        case 'tsv':
        case 'gmt':

          $destino = $dirDestino . $nome_final;

          if (move_uploaded_file($origem, $destino)){

            if ($tipo == "phenotypic" or $tipo == "gmt") {

              $delm="\t";

              if ($tipo == "phenotypic") {

                $colunaClass=1;

              } elseif ($tipo == "gmt") {

                $colunaClass=0;

              }

              $arquivo = fopen($dirDestino . $nome_final, "r");

              if ($arquivo) {
                
                while(!feof($arquivo)){ 
                  $linhas[] = explode($delm, fgets($arquivo));
                }

                fclose($arquivo);
                  
                unset($linhas[0]);
                unset($linhas[count($linhas)]);

                foreach($linhas as $elemento){
                  $arrayClass_before[] = $elemento[$colunaClass];
                }

                // Remove duplicates class and organize id values 
                $arrayClass = array_values(array_unique($arrayClass_before));

                $jsonClass = array();

                if ($tipo == "phenotypic") {

                  $jsonClass['classes1'] = array();
                  // Show class
                  foreach ($arrayClass as $item) {
                    $jsonClass['classes1'][] = $item;
                  }

                } elseif ($tipo == "gmt") {

                  $jsonClass['classes2'] = array();
                  // Show class
                  foreach ($arrayClass as $item) {
                    $jsonClass['classes2'][] = $item;
                  }

                }

                echo json_encode($jsonClass);  

              }

            }

          } else {

            // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            $json['error'] = "Couldn't send file, please, try again";
            echo json_encode($json);
            exit; // Para a execução do script

          }

          //echo json_encode($jsonClass);

        break;

        case 'zip':

          $destino = $dirDestino . $nome_final_zip;

          // Verifica se é possível mover o arquivo para a pasta escolhida
          if (move_uploaded_file($origem, $destino)){
            
            // Upload efetuado com sucesso

            $zip = new ZipArchive;
            
            if ($zip->open($destino) === TRUE) {

                if ($zip->numFiles != 1) {

                  $json['error'] = "Exist more one file (or null) in zip file";
                  echo json_encode($json);
                  exit;

                } else {

                  $arquivo_extraido = $zip->getNameIndex(0);

                }
              
                $zip->extractTo($dirDestino);

                $zip->close();

                //$json['success'] = "Extracted zip file successful.";
                //echo json_encode($json);

                if (unlink($destino)){
                
                  //$json['success'] = "Deleted zip file successful.";
                  //echo json_encode($json);

                }

                $origem = $dirDestino . $arquivo_extraido;
                $destino = $dirDestino . $nome_final;

                // RENOMEAR APÓS EXTRACAO

                if (rename($origem, $destino)){

                  // Upload efetuado com sucesso 
                  //$json['success'] = "File renamed successful";
                  //echo json_encode($json);

                  /* CASO QUISESSE ENVIAR ZIP DO PHENOTYPIC E GMT

                  if ($tipo == "phenotypic" or $tipo == "gmt"){

                    $extensao = $this->verificaExtensao($nome_final,$_UP['extensoes']);

                    $this->moveArquivo($tipo, $extensao, $destino, $dirDestino);
                    
                  }

                  */

                } else {

                  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
                  $json['error'] = "Couldn't moved final file, please, try again";
                  echo json_encode($json);
                  exit; // Para a execução do script

                }

            } else {
            
                $json['error'] = "Failed.";
                echo json_encode($json);

            }      

          } else {
            // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            $json['error'] = "Couldn't send file, please, try again";
            echo json_encode($json);
            exit; // Para a execução do script
          }

        break;

    } // FIM DO CASE

  //echo json_encode($json);

  } // FIM DO METODO MOVEARQUIVO

} // FIM DA CLASSE MDPACTIONS
 
$run = new mdpActions();

/*
EXPRESSIONDATA UPLOAD
*/
if ( $_FILES['expressionData']['size'] != 0 ) {

  $tipo = "expression";

  // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
  if ($_FILES['expressionData']['error'] != 0) {
    $json['error'] = "Couldn't complete file upload because: " . $_UP['erros'][$_FILES['expressionData']['error']];
    echo json_encode($json);
    exit; // Para a execução do script
  }

  $extensao = $run->verificaExtensao($_FILES['expressionData']['name'],$_UP['extensoes']);

  $run->verificaTamanho($_FILES['expressionData']['size'], $_UP['tamanho']);

  $run->moveArquivo($tipo, $extensao, $_FILES['expressionData']['tmp_name'], $_UP['pasta']);

}
  
/*
PHENOTYPICDATA UPLOAD
*/
if ( $_FILES['phenotypicData']['size'] != 0 ) {

  $tipo = "phenotypic";

  // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
  if ($_FILES['phenotypicData']['error'] != 0) {
    $json['error'] = "Couldn't complete file upload because: " . $_UP['erros'][$_FILES['phenotypicData']['error']];
    echo json_encode($json);
    exit; // Para a execução do script
  }

  $extensao = $run->verificaExtensao($_FILES['phenotypicData']['name'],$_UP['extensoes']);

  $run->verificaTamanho($_FILES['phenotypicData']['size'], $_UP['tamanho']);

  $run->moveArquivo($tipo, $extensao, $_FILES['phenotypicData']['tmp_name'], $_UP['pasta']);

}

/*
PATHWAYS GMT FILE UPLOAD
*/
if ( $_FILES['pathwaysGMT']['size'] != 0 ) {

  $tipo = "gmt";

  // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
  if ($_FILES['pathwaysGMT']['error'] != 0) {
    $json['error'] = "Couldn't complete file upload because: " . $_UP['erros'][$_FILES['pathwaysGMT']['error']];
    echo json_encode($json);
    exit; // Para a execução do script
  }

  $extensao = $run->verificaExtensao($_FILES['pathwaysGMT']['name'],$_UP['extensoes']);

  $run->verificaTamanho($_FILES['pathwaysGMT']['size'], $_UP['tamanho']);

  $run->moveArquivo($tipo, $extensao, $_FILES['pathwaysGMT']['tmp_name'], $_UP['pasta']);

}

?>