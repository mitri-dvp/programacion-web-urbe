<?php
  if (isset($_GET['path'])) {
    $path = $_GET['path'];
  } else {
    $path = getcwd();
    $path = str_replace("\\", "/", $path)."/";
  }
  $path_array = explode('/', $path);
  
  $extensions = ["blank","docx","exe","folder","html","jpg","pdf","php","png","svg","txt"];
  $directory = scandir($path);
  $last_path_length = strlen($path_array[count($path_array) - 2]);
  $up_path = substr($path, 0 , strlen($path) - $last_path_length - 1);

  $files = [];
  $folders = [];
  for ($i=0; $i < count($directory); $i++) {
    if (is_dir($path.$directory[$i]) != true) {
      array_push($files, $directory[$i]);
    } else {
      array_push($folders, $directory[$i]);
    }
  }

  if (isset($_GET['element'])) {
    $element = $_GET['element'];
  } else {
    $element = 'file';
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Aplicación Bloc de Notas</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="../assets/files/icon.svg">
</head>

<body>
  <div id="bloc">
    <h3 class="title">Aplicación Bloc de Notas:</h3>
    
    <hr>

    <div class="viewport">
      <div class="path">
      <?php
      $current_path = "";
      for ($i = 0; $i < count($path_array) - 1; $i++) {
        $current_path = $current_path.$path_array[$i]."/";
      ?>
        <a href="?path=<?= $current_path ?>" class="item">
          <?= $path_array[$i] ?>
        </a>
      <?php } ?>
      </div>
      <div class="directory">
      <?php for ($i = 0; $i < count($folders); $i++) {
        $current_folder = pathinfo($folders[$i]);
        if($current_folder['basename'] === ".") {
      ?>
        <a href="?path=<?= $current_path ?>" class="item">
        <img src="../assets/files/folder.svg" alt="">
          <span><?= $current_folder['basename']?></span>
        </a>
      <?php
        } elseif ($current_folder['basename'] === "..") {
      ?>
        <a href="?path=<?= $up_path ?>" class="item">
          <img src="../assets/files/folder.svg" alt="">
            <span><?= $current_folder['basename']?></span>
          </a>
      <?php
        } else {
      ?>
        <a href="?path=<?= $current_path.$current_folder['basename']."/" ?>" class="item">
        <img src="../assets/files/folder.svg" alt="">
          <span><?= $current_folder['basename']?></span>
        </a>
      <?php
        }
      }
      for ($i = 0; $i < count($files); $i++) {
        $current_file = pathinfo($files[$i]);
        if(isset($current_file['extension'])) {

          if(in_array($current_file['extension'], $extensions)) {
            $image = $current_file['extension'];
          } else {
            $image = 'blank';
          }
          if($current_file['extension'] === 'txt') {
            ?>
              <a href="?path=<?= $current_path ?>&txt_file=<?= $current_file['basename']?>" class="item">
                <img src="../assets/files/<?= $image ?>.svg" alt="">
                <span><?= $current_file['basename']?></span>
              </a>
            <?php
              } else {
            ?>
              <a href="#" class="item">
                <img src="../assets/files/<?= $image ?>.svg" alt="">
                <span><?= $current_file['basename']?></span>
              </a>
            <?php
              }
        } else {
          $image = 'blank';
          ?>
          <a href="#" class="item">
            <img src="../assets/files/<?= $image ?>.svg" alt="">
            <span><?= $current_file['basename']?></span>
          </a>
        <?php
        }
      }
      ?>
      <a href="#" class="item last"></a>
      <a href="#" class="item last"></a>
      <a href="#" class="item last"></a>
      <a href="#" class="item last"></a>
      </div>
    </div>

    <?php
    if($element === 'file') {
      ?>
      <form method="GET">
        <input name="path" type="text" value="<?= $current_path ?>" class="hidden">
        <select onchange="this.form.submit()" name="element">
          <option value="file">Archivo</option>
          <option value="directory">Directorio</option>
        </select>
      </form>
      <h3>Gestor de Archivos</h3>
      <form method="POST">
        <input name="path" type="text" value="<?= $current_path ?>" class="hidden">
        <label>
          <span>Nombre</span>
          <input name="name" type="text">
        </label>
        <label>
          <span>Contenido</span>
          <textarea name="content" id="" cols="30" rows="10"></textarea>
        </label>
        <input type="submit" value="CREAR">
      </form>
      <?php
    } else {
      ?>
      <form method="GET">
        <input name="path" type="text" value="<?= $current_path ?>" class="hidden">
        <select onchange="this.form.submit()" name="element">
          <option value="directory">Directorio</option>
          <option value="file">Archivo</option>
        </select>
      </form>
      <h3>Gestor de Directorios</h3>
      <form method="POST">
        <input name="path" type="text" value="<?= $current_path ?>" class="hidden">
        <label>
          <span>Nombre</span>
          <input name="name" type="text">
        </label>
        <input type="submit" value="CREAR">
      </form>
      <?php
    }
    ?>

    <hr>

    <div class=" links">
      <a href="../index.html">Volver</a>
      <a target="_blank" href="https://github.com/mitri-dvp/programacion-web-urbe/blob/main/web/php/bloc.php">Repositorio</a>
    </div>
  </div>

  <script>
    const path = document.querySelector(".path");
    path.scrollLeft = path.getBoundingClientRect().width + 100
    path.addEventListener("wheel", e => {
        e.preventDefault();
        path.scrollLeft += e.deltaY * -1;
    });

    const showAlert = (txt, type) => {
      const alert = document.createElement('div')
      alert.classList.add('alert')
      alert.classList.add(type)
      alert.innerText = txt
      console.log(alert)
      document.querySelector('#bloc').appendChild(alert)
      alert.onclick = () => alert.remove()
      setTimeout(() => {
        alert.remove()
      }, 3000);
    }
  </script>
  <?php
    if(isset($_GET['txt_file'])) {
    $file_path = $current_path.$_GET['txt_file'];
    $fp = fopen($file_path, 'r+');
    filesize($file_path) === 0 ? $size = 1 : $size = filesize($file_path);
    $contents = fread($fp, $size);
  ?>
    <script>
      const modal = document.createElement('div')
      const removeModal = () => {
        modal.remove()
      }
      modal.classList.add('modal')
      modal.innerHTML = `
        <form method="POST">
          <div class="delete" onClick="removeModal()">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="#e74c3c" class="bi bi-x" viewBox="0 0 16 16">
              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
          </div>
          <input class="hidden" type="text" name="path" value="<?= $current_path ?>">
          <input class="hidden" type="text" name="txt_file" value="<?= $_GET['txt_file'] ?>">
          <h3><?= $_GET['txt_file'] ?></h3>
          <textarea cols="30" rows="20" name="txt_value"><?= $contents ?></textarea>
          <input type="submit" value="GUARDAR">
        </form>  
      `
      document.querySelector('#bloc').appendChild(modal)
    </script>
    <?php
    }
  ?>
  <?php
  if(isset($_POST['txt_file']) && isset($_POST['path']) && isset($_POST['txt_value'])) {
    ?><script>modal.remove()</script><?php
    $file_path = $current_path.$_POST['txt_file'];
    $txt_file = $_POST['txt_file'];
    $txt_value = $_POST['txt_value'];
    $path = $_POST['path'];
    
    $fp = fopen($file_path, "w");
    $fwrite = fwrite($fp, $txt_value);
    if ($fwrite != false || $txt_value === '') {
      ?><script>showAlert('Archivo <?= $_POST['txt_file'] ?> guardado con éxito.', 'success')</script><?php
    } else {
      ?><script>showAlert('Error con archivo "<?= $_POST['txt_file'] ?>".', 'error')</script><?php
    }
    fclose($fp);
  }
  ?>
  <?php
  if(isset($_POST['name']) && !isset($_POST['content'])) {
    $dir_path = $current_path.$_POST['name'];
    $path = $_POST['path'];
    $mkdir = mkdir($dir_path);

    if ($mkdir != false || $content === '') {
      ?><script>showAlert('Directorio <?= $_POST['name'] ?> creado con éxito.', 'success');window.location.href = window.location.href;</script><?php
    } else {
      ?><script>showAlert('Error creando directorio "<?= $_POST['name'] ?>".', 'error')</script><?php
    }
  }
  ?>
  <?php
  if(isset($_POST['name']) && isset($_POST['content'])) {
    $file_path = $current_path.$_POST['name'];
    $content = $_POST['content'];
    $path = $_POST['path'];

    $fp = fopen($file_path.".txt", "x+");
    $fwrite = fwrite($fp, $content);
    if ($fwrite != false || $content === '') {
      ?><script>showAlert('Archivo <?= $_POST['name'] ?> creado con éxito.', 'success');window.location.href = window.location.href;</script><?php
    } else {
      ?><script>showAlert('Error creando archivo "<?= $_POST['name'] ?>".', 'error')</script><?php
    }
    fclose($fp);
  }
  ?>
</body>
</html>