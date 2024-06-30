<?php
$lang = 'en'; // Default language
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
}

$lang_file = "lang/$lang.php";
if (file_exists($lang_file)) {
    $translations = include($lang_file);
} else {
    $translations = include("lang/en.php");
}
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($translations['title']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

    <link rel="icon" type="image/x-icon" href="images/jwlmerge.ico">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="images/jwlmerge.png" height="30"/> &nbsp;
            <h1><?php echo htmlspecialchars($translations['header']); ?></h1>
        </div>
        
        <div class="language-selector">
             <a href="?lang=en"><span class="flag-icon flag-icon-us flag" data-lang="en"></span></a>
            <a href="?lang=fr"><span class="flag-icon flag-icon-fr flag" data-lang="fr"></span></a>
             
             <div class="more-lang">
             <i class="fas fa-square-caret-down more"></i>
              <div class="more-flags">
                <a href="?lang=it"><span class="flag-icon flag-icon-it flag" data-lang="it"></span></a>
                  <a href="?lang=es"><span class="flag-icon flag-icon-es flag" data-lang="es"></span></a>
                  <a href="?lang=de"><span class="flag-icon flag-icon-de flag" data-lang="de"></span></a>
                  <a href="?lang=zh"><span class="flag-icon flag-icon-cn flag" data-lang="zh"></span></a>
                  <a href="?lang=eh"><span class="flag-icon flag-icon-eh flag" data-lang="eh"></span></a>
                  <a href="?lang=ru"><span class="flag-icon flag-icon-ru flag" data-lang="ru"></span></a>
                  <a href="?lang=ja"><span class="flag-icon flag-icon-jp flag" data-lang="jp"></span></a>
                  <a href="?lang=pt"><span class="flag-icon flag-icon-pt flag" data-lang="pt"></span></a>
                  <a href="?lang=tg"><span class="flag-icon flag-icon-ph flag" data-lang="tg"></span></a>
                  <a href="?lang=he"><span class="flag-icon flag-icon-il flag" data-lang="he"></span></a>
              </div>
            </div>
        </div>
        
    
        <?php if (isset($_GET['output']) && isset($_GET['mergedFilePath'])): ?>
        <div class="header-buttons">
            <a href="<?php echo htmlspecialchars($_GET['mergedFilePath']); ?>" class="btn btn-success">
                <i class="fas fa-download"></i> <?php echo htmlspecialchars($translations['download_merged_file']); ?>
            </a>
             <form action="delete_merged.php" method="post" style="display:inline;">
                <input type="hidden" name="mergedFilePath" value="<?php echo htmlspecialchars($_GET['mergedFilePath']); ?>">
                <button type="submit" class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i> <?php echo htmlspecialchars($translations['delete_and_homepage']); ?>
                </button>
            </form>
        </div>
        <?php endif; ?>
    </header>
    <div class="container">
        <h2><?php echo htmlspecialchars($translations['header']); ?> <span class="tooltip"><i class="fa-regular fa-circle-question"></i><span class="tooltiptext"><?php echo $translations['tooltip_text']; ?></span></span></h2>
        <?php if (isset($_GET['output']) && isset($_GET['mergedFilePath'])): ?>
        <div class="output-container">
            <h3><?php echo htmlspecialchars($translations['merge_output']); ?></h3>
            <pre><?php echo htmlspecialchars($_GET['output']); ?></pre>
        </div>
        <?php else: ?>
        <form action="merge.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file1"><?php echo htmlspecialchars($translations['select_file1']); ?></label>
                <input type="file" id="file1" name="file1" accept=".jwlibrary" required>
            </div>
            <div class="form-group">
                <label for="file2"><?php echo htmlspecialchars($translations['select_file2']); ?></label>
                <input type="file" id="file2" name="file2" accept=".jwlibrary" required>
            </div>
            <?php echo htmlspecialchars($translations['conflict_autoresolution']); ?><br/>
            <div class="conflict-autoresolution">
                <div class="mrgdrop">
                    <i class="btndrop mrgdrop-left"><i class="fas fa-bookmark"></i></i>
                    <div class="mrgdrop-content">
                        <a href="#" onclick="setOption('bookmarks', 'chooseLeft')">File1</a>
                        <a href="#" onclick="setOption('bookmarks', 'chooseRight')">File2</a>
                    </div>
                </div>
                <div class="mrgdrop">
                    <i class="btndrop mrgdrop-center"><i class="fas fa-highlighter"></i></i>
                    <div class="mrgdrop-content">
                        <a href="#" onclick="setOption('highlight', 'chooseLeft')">File1</a>
                        <a href="#" onclick="setOption('highlight', 'chooseRight')">File2</a>
                    </div>
                </div>
                <div class="mrgdrop">
                    <i class="btndrop mrgdrop-center"><i class="fas fa-comment-dots"></i></i>
                    <div class="mrgdrop-content">
                        <a href="#" onclick="setOption('inputFields', 'chooseLeft')">File1</a>
                        <a href="#" onclick="setOption('inputFields', 'chooseRight')">File2</a>
                    </div>
                </div>
                <div class="mrgdrop">
                    <i class="btndrop mrgdrop-right"><i class="fas fa-note-sticky"></i></i>
                    <div class="mrgdrop-content">
                        <a href="#" onclick="setOption('notes', 'chooseNewest ')"><?php echo htmlspecialchars($translations['notes']); ?></a>
                        <a href="#" onclick="setOption('notes', 'chooseLeft')">File1</a>
                        <a href="#" onclick="setOption('notes', 'chooseRight')">File2</a>
                    </div>
                </div>
            </div>
            <input type="hidden" name="options" id="options" value='{"bookmarks":"chooseLeft","highlight":"chooseLeft","notes":"chooseNewest","inputFields":"chooseLeft"}'>
            <input type="hidden" name="lang" id="lang" value=<?php echo $lang; ?>  >
            <div class="form-group">
                <button type="submit" class="btn"><i class="fas fa-file-archive"></i><?php echo htmlspecialchars($translations['merge_files']); ?></button>
            </div>
        </form>
        <i class="fas fa-triangle-exclamation"></i> <?php echo htmlspecialchars($translations['playlist_notice']); ?>
        <script>
            const options = {
                bookmarks: 'chooseLeft',
                highlight: 'chooseLeft',
                notes: 'chooseNewest',
                inputFields: 'chooseLeft'
            };

            function setOption(type, value) {
                options[type] = value;
                document.getElementById('options').value = JSON.stringify(options);
                console.log(`Set ${type} to ${value}`);
            }


        </script>
        <?php endif; ?>
    </div>
    <footer>
        <div class="container">
            <div class="disclaimer">
                <p><i class="fas fa-circle-info"></i> <?php echo htmlspecialchars($translations['max_file_size']); ?></p>
            </div>
            <p class="note"><?php echo htmlspecialchars($translations['note']); ?> <a href="https://github.com/AndreasSko/go-jwlm">AndreasSko - go-jwlm</a> . </p>
        </div>
    </footer>
</body>
</html>
