<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(2, "mi_encuestas", $Language->MenuPhrase("2", "MenuText"), "encuestaslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(5, "mi_plantilla_encuestas", $Language->MenuPhrase("5", "MenuText"), "plantilla_encuestaslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(1, "mi_clientes", $Language->MenuPhrase("1", "MenuText"), "clienteslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(3, "mi_eventos", $Language->MenuPhrase("3", "MenuText"), "eventoslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(4, "mi_idioma", $Language->MenuPhrase("4", "MenuText"), "idiomalist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(10, "mi_controles", $Language->MenuPhrase("10", "MenuText"), "controleslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(6, "mi_usuarios", $Language->MenuPhrase("6", "MenuText"), "usuarioslist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(9, "mi_audittrail", $Language->MenuPhrase("9", "MenuText"), "audittraillist.php", -1, "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
