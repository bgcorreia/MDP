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
  $_UP['extensoes'] = array('tsv' , 'gmt');
  
  // Renomeia o arquivo? (Se true, o arquivo será salvo como .tsv e um nome único)
  $_UP['renomeia'] = true;
  
  // Array com os tipos de erros de upload do PHP
  $_UP['erros'][0] = "There wasn't any problem";
  $_UP['erros'][1] = "Uploaded file is larger than the PHP limit";
  $_UP['erros'][2] = "Uploaded file is larger than the limit";
  $_UP['erros'][3] = "O upload do arquivo foi feito parcialmente";
  $_UP['erros'][4] = "The file wasn't sent";
 
  /*
  EXPRESSIONDATA UPLOAD
  */
  if ( $_FILES['expressionData']['size'] != 0 ) {

    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if ($_FILES['expressionData']['error'] != 0) {
      $json['error'] = "Couldn't complete file upload because: " . $_UP['erros'][$_FILES['expressionData']['error']];
      echo json_encode($json);
      exit; // Para a execução do script
    }

    // Caso o script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
    // Faz a verificação da extensão do arquivo
    $preextensao = explode('.', $_FILES['expressionData']['name']); 
    // Se fizer tudo direto o php retorna um erro
    // PHP Notice:  Only variables should be passed by reference 
    $extensao = strtolower(end($preextensao));
    if (array_search($extensao, $_UP['extensoes']) === false) {
      $json['error'] = "Please, send files with the following extension(s): tsv";
      echo json_encode($json);
      exit;
    }

    // Faz a verificação do tamanho do arquivo
    if ($_FILES['expressionData']['size'] > $_UP['tamanho']){
      $json['error'] = "Uploaded file is too large. The file size limit is " . $fileSizeMB . ".";
      echo json_encode($json);
      exit; // Para a execução do script
    }

    // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
    // Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
      // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .tsv
      //$nome_final = md5(time()).'.tsv';
      $nome_final = 'edata.tsv';
    } else {
      // Mantém o nome original do arquivo
      $nome_final = $_FILES['expressionData']['name'];
    }
      
    // Depois verifica se é possível mover o arquivo para a pasta escolhida
    if (move_uploaded_file($_FILES['expressionData']['tmp_name'], $_UP['pasta'] . $nome_final)) {
      // Upload efetuado com sucesso
    } else {
      // Não foi possível fazer o upload, provavelmente a pasta está incorreta
      $json['error'] = "Couldn't send file, please, try again";
      echo json_encode($json);
      exit; // Para a execução do script
    }
  }

  /*
  PHENOTYPICDATA UPLOAD
  */
  if ( $_FILES['phenotypicData']['size'] != 0 ) {

    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if ($_FILES['phenotypicData']['error'] != 0) {
      $json['error'] = "Couldn't complete file upload because: " . $_UP['erros'][$_FILES['phenotypicData']['error']];
      echo json_encode($json);
      exit; // Para a execução do script
    }

    // Caso o script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
    // Faz a verificação da extensão do arquivo
    $preextensao = explode('.', $_FILES['phenotypicData']['name']); 
    // Se fizer tudo direto o php retorna um erro
    // PHP Notice:  Only variables should be passed by reference 
    $extensao = strtolower(end($preextensao));
    if (array_search($extensao, $_UP['extensoes']) === false) {
      $json['error'] = "Please, send files with the following extension(s): tsv";
      echo json_encode($json);
      exit;
    }

    // Faz a verificação do tamanho do arquivo
    if ($_FILES['phenotypicData']['size'] > $_UP['tamanho']) {
      $json['error'] = "Uploaded file is too large. The file size limit is " . $fileSizeMB . ".";
      echo json_encode($json);
      exit; // Para a execução do script
    }
    // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
    // Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
      // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .tsv
      //$nome_final = md5(time()).'.tsv';
      $nome_final = 'pdata.tsv';
    } else {
      // Mantém o nome original do arquivo
      $nome_final = $_FILES['phenotypicData']['name'];
    }
      
    // Depois verifica se é possível mover o arquivo para a pasta escolhida
    if (move_uploaded_file($_FILES['phenotypicData']['tmp_name'], $_UP['pasta'] . $nome_final)) {
      // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
      $delm="\t";
      $colunaClass=1;

      $arquivo = fopen($_UP['pasta'] . $nome_final, "r");

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

        $json['classes1'] = array();
        // Show class
        foreach ($arrayClass as $item) {
          $json['classes1'][] = $item;
        }

      }

    } else {
      // Não foi possível fazer o upload, provavelmente a pasta está incorreta
      $json['error'] = "Couldn't send file, please, try again";
      echo json_encode($json);
      exit; // Para a execução do script
    }
  }

  /*
  PATHWAYS GMT FILE UPLOAD
  */
  if ( $_FILES['pathwaysGMT']['size'] != 0 ) {

    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if ($_FILES['pathwaysGMT']['error'] != 0) {
      $json['error'] = "Couldn't complete file upload because: " . $_UP['erros'][$_FILES['pathwaysGMT']['error']];
      echo json_encode($json);
      exit; // Para a execução do script
    }

    // Caso o script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
    // Faz a verificação da extensão do arquivo
    $preextensao1 = explode('.', $_FILES['pathwaysGMT']['name']); 
    // Se fizer tudo direto o php retorna um erro
    // PHP Notice:  Only variables should be passed by reference 
    $extensao1 = strtolower(end($preextensao1));
    if (array_search($extensao1, $_UP['extensoes']) === false) {
      $json['error'] = "Please, send files with the following extension(s): gmt";
      echo json_encode($json);
      exit;
    }

    // Faz a verificação do tamanho do arquivo
    if ($_FILES['pathwaysGMT']['size'] > $_UP['tamanho']) {
      $json['error'] = "Uploaded file is too large. The file size limit is " . $fileSizeMB . ".";
      echo json_encode($json);
      exit; // Para a execução do script
    }
    // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
    // Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
      // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .tsv
      //$nome_final = md5(time()).'.tsv';
      $nome_final1 = 'pathways.gmt';
    } else {
      // Mantém o nome original do arquivo
      $nome_final1 = $_FILES['pathwaysGMT']['name'];
    }
      
    // Depois verifica se é possível mover o arquivo para a pasta escolhida
    if (move_uploaded_file($_FILES['pathwaysGMT']['tmp_name'], $_UP['pasta'] . $nome_final1)) {
      // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
      $delm1="\t";
      $colunaClass1=0;

      $arquivo1 = fopen($_UP['pasta'] . $nome_final1, "r");

      if ($arquivo1) {
        
        while(!feof($arquivo1)){ 
          $linhas1[] = explode($delm1, fgets($arquivo1));
        }

        fclose($arquivo1);
          
        unset($linhas1[0]);
        unset($linhas1[count($linhas1)]);

        foreach($linhas1 as $elemento1){
          $arrayClass_before1[] = $elemento1[$colunaClass1];
        }

        // Remove duplicates class and organize id values 
        $arrayClass1 = array_values(array_unique($arrayClass_before1));

        $json['classes2'] = array();
        // Show class
        foreach ($arrayClass1 as $item1) {
          $json['classes2'][] = $item1;
        }

      }

    } else {
      // Não foi possível fazer o upload, provavelmente a pasta está incorreta
      $json['error'] = "Couldn't send file, please, try again";
      echo json_encode($json);
      exit; // Para a execução do script
    }
  }

  echo json_encode($json);

?>
