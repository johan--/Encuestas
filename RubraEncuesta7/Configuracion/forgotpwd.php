<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg11.php" ?>
<?php include_once "ewmysql11.php" ?>
<?php include_once "phpfn11.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn11.php" ?>
<?php

//
// Page class
//

$forgotpwd = NULL; // Initialize page object first

class cforgotpwd extends cusuarios {

	// Page ID
	var $PageID = 'forgotpwd';

	// Project ID
	var $ProjectID = "{ADE930FF-1B1F-40A3-B075-C7C26BDE4A4A}";

	// Page object name
	var $PageObjName = 'forgotpwd';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		return TRUE;
	}
	var $Token = "";
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (usuarios)
		if (!isset($GLOBALS["usuarios"]) || get_class($GLOBALS["usuarios"]) == "cusuarios") {
			$GLOBALS["usuarios"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["usuarios"];
		}
		if (!isset($GLOBALS["usuarios"])) $GLOBALS["usuarios"] = &$this;

		// User table object (usuarios)
		if (!isset($GLOBALS["UserTable"])) $GLOBALS["UserTable"] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'forgotpwd', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn, $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $Email = "";
	var $Action = "";
	var $ActivateCode = "";

	//
	// Page main
	//
	function Page_Main() {
		global $conn, $Language, $gsFormError;
		global $Breadcrumb;
		$Breadcrumb = new cBreadcrumb;
		$Breadcrumb->Add("forgotpwd", "RequestPwdPage", ew_CurrentUrl(), "", "", TRUE);
		$bPostBack = ew_IsHttpPost();
		$bValidEmail = FALSE;
		if ($bPostBack) {

			// Setup variables
			$this->Email = $_POST["email"];
			$bValidEmail = $this->ValidateForm($this->Email);
			if ($bValidEmail) {
				$this->Action = "activate";
				$this->ActivateCode = ew_Encrypt($this->Email);
			} else {
				$this->setFailureMessage($gsFormError);
			}

		// Handle email activation
		} elseif (@$_GET["action"] <> "") {
			$this->Action = $_GET["action"];
			$this->Email = @$_GET["email"];
			$this->ActivateCode = @$_GET["code"];
			if ($this->Email <> ew_Decrypt($this->ActivateCode) || strtolower($this->Action) <> "confirm") { // Email activation
				if ($this->getFailureMessage() == "")
					$this->setFailureMessage($Language->Phrase("ActivateFailed")); // Set activate failed message
				$this->Page_Terminate("login.php"); // Go to login page
			}
		}
		if ($this->Action <> "") {
			$bEmailSent = FALSE;

			// Set up filter (SQL WHERE clause) and get Return SQL
			// SQL constructor in usuarios class, usuariosinfo.php

			$sFilter = str_replace("%e", ew_AdjustSql($this->Email), EW_USER_EMAIL_FILTER);
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			if ($RsUser = $conn->Execute($sSql)) {
				if (!$RsUser->EOF) {
					$rsold = $RsUser->fields;
					$bValidEmail = TRUE;

					// Call User Recover Password event
					$bValidEmail = $this->User_RecoverPassword($rsold);
					if ($bValidEmail) {
						$sUserName = $rsold['usuario'];
						$sPassword = $rsold['password'];
						if (EW_ENCRYPTED_PASSWORD) {
							if (strtolower($this->Action) == "confirm") {
								$sPassword = substr($sPassword, 0, 16); // Use first 16 characters only
								$rsnew = array('password' => $sPassword); // Reset the password
								$this->Update($rsnew);
							}
						} else {
							$this->Action = "confirm"; // Send password directly if not MD5
						}
					}
				} else {
					$bValidEmail = FALSE;
					$this->setFailureMessage($Language->Phrase("InvalidEmail"));
				}
				if ($bValidEmail) {
					$Email = new cEmail();
					if (strtolower($this->Action) == "confirm") {
						$Email->Load("phptxt/forgotpwd.txt");
						$Email->ReplaceContent('<!--$Password-->', $sPassword);
					} else {
						$Email->Load("phptxt/resetpwd.txt");
						$sActivateLink = ew_FullUrl() . "?action=confirm";
						$sActivateLink .= "&email=" . $this->Email;
						$sActivateLink .= "&code=" . $this->ActivateCode;
						$Email->ReplaceContent('<!--$ActivateLink-->', $sActivateLink);
					}
					$Email->ReplaceSender(EW_SENDER_EMAIL); // Replace Sender
					$Email->ReplaceRecipient($this->Email); // Replace Recipient
					$Email->ReplaceContent('<!--$UserName-->', $sUserName);
					$Email->Charset = EW_EMAIL_CHARSET;
					$Args = array();
					if (EW_ENCRYPTED_PASSWORD && strtolower($this->Action) == "confirm") $Args["rs"] = &$rsnew;
					if ($this->Email_Sending($Email, $Args))
						$bEmailSent = $Email->Send();
				}
				$RsUser->Close();
			}
			if ($bEmailSent) {
				if ($this->getSuccessMessage() == "")
					if (strtolower($this->Action) == "confirm")
						$this->setSuccessMessage($Language->Phrase("PwdEmailSent")); // Set up success message
					else
						$this->setSuccessMessage($Language->Phrase("ResetPwdEmailSent")); // Set up success message
				$this->Page_Terminate("login.php"); // Return to login page
			} elseif ($bValidEmail) {
				$this->setFailureMessage($Email->SendErrDescription); // Set up error message
			}
		}
	}

	//
	// Validate form
	//
	function ValidateForm($email) {
		global $gsFormError, $Language;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if ($email == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterValidEmail"));
		}
		if (!ew_CheckEmail($email)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterValidEmail"));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form Custom Validate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// User RecoverPassword event
	function User_RecoverPassword(&$rs) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($forgotpwd)) $forgotpwd = new cforgotpwd();

// Page init
$forgotpwd->Page_Init();

// Page main
$forgotpwd->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$forgotpwd->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<script type="text/javascript">
var fforgotpwd = new ew_Form("fforgotpwd");

// Extend page with Validate function
fforgotpwd.Validate = function()
{
	var fobj = this.Form;
	if (!this.ValidateRequired)
		return true; // Ignore validation
	if  (!ew_HasValue(fobj.email))
		return this.OnError(fobj.email, ewLanguage.Phrase("EnterValidEmail"));
	if  (!ew_CheckEmail(fobj.email.value))
		return this.OnError(fobj.email, ewLanguage.Phrase("EnterValidEmail"));

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// Extend form with Form_CustomValidate function
fforgotpwd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Requires js validation
<?php if (EW_CLIENT_VALIDATE) { ?>
fforgotpwd.ValidateRequired = true;
<?php } else { ?>
fforgotpwd.ValidateRequired = false;
<?php } ?>
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $forgotpwd->ShowPageHeader(); ?>
<?php
$forgotpwd->ShowMessage();
?>
<form name="fforgotpwd" id="fforgotpwd" class="form-horizontal ewForm ewForgotpwdForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($forgotpwd->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $forgotpwd->Token ?>">
<?php } ?>
	<div class="form-group">
		<label class="col-sm-2 control-label ewLabel" for="email"><?php echo $Language->Phrase("UserEmail") ?></label>
		<div class="col-sm-10"><input type="text" name="email" id="email" class="form-control ewControl" value="<?php ew_HtmlEncode($forgotpwd->Email) ?>" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("UserEmail")) ?>"></div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SendPwd") ?></button>
		</div>
	</div>
</form>
<script type="text/javascript">
fforgotpwd.Init();
</script>
<?php
$forgotpwd->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$forgotpwd->Page_Terminate();
?>
