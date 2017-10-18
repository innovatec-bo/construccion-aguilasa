<?php 
/**
 * @var Model_User
 */
$sessUser;

/**
 * @var Model_AllowedStructure
 */
$allowedStructure;
?>

  <!-- Fixed navbar -->
  <div id="head-nav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="fa fa-gear"></span>
        </button>
        <button type="button" class="navbar-toggle intro">
          Start tour
        </button>        
        <a class="navbar-brand" href="<?= base_url("panel"); ?>">
            <img alt="Avatar" style="max-height: 30px; max-width: 160px;" src="<?php
            if ($site->getLogoModelFile() !== null)
            {
                $gnFile = new GN_File();
                echo $gnFile->getThumbnail($site->getLogoModelFile(), 160, 30);
            }
            else
            {
                echo tmpl_lib_url("img/default-logo.png");
            }
            ?>" />
        </a>
      </div>
      <div class="navbar-collapse collapse">
        <?php echo  $gnNavigation->getMenu("main")->render("nav navbar-nav"); ?>
        <ul class="nav navbar-nav navbar-right user-nav">
       	
          <li class="dropdown profile_menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img alt="Avatar" src="<?php
            if ($sessUser->getAvatarModelFile() !== null)
            {
                $gnFile = new GN_File();
                echo $gnFile->getThumbnail($sessUser->getAvatarModelFile(), 30, 30);
            }
            else
            {
                echo panel_url("images/no-avatar-small.jpg");
            }
            ?>" /><span><?php echo $sessUser->getFullName(); ?></span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url();?>panel/user/edit/<?php echo $sessUser->getId(); ?>">My Profile</a></li>
              <li class="divider"></li>
              <li><a href="/logout">Sign Out</a></li>
            </ul>
          </li>
		  <li>
			<a href="#" class="navbar-toggle intro" id="topintro">
          		Start tour
        	</a>
		  </li>           
        </ul>
        <ul class="nav navbar-nav navbar-right user-nav">
            <li>
                <form id="allowed-organizations-form" action="<?echo base_url("/panel/organization/changeCurrentOrganization")?>" method="get">
                    <?php if($gnSecurity->isSuperAdmin() === true) { ?>
                    <input type="hidden" id="ajax-current-organization" name="organizationId" value='
                        <?php
                            $currentOrganization = Model_Organization::getById($allowedStructure->getCurrentOrganizationId());
                            if ($currentOrganization != null) {
                                echo '{"id":"'.$currentOrganization->getId().'","text":"'.$currentOrganization->getName().'"}';
                            }
                        ?>
                    '>
                    <?php } else { ?>
                    <select id="current-organization" class="checkbox-panel" name="organizationId">
                        <?php
                            $organizationsArray = Model_Organization::getAllInIdsArray($allowedStructure->getVisibleOrganizationIds(), 1000, 0);
                            foreach ($organizationsArray as $organization) {
                                $html = "<option value=\"". $organization->getId(). "\"";
                                if ($allowedStructure != null && $organization->getId() == $allowedStructure->getCurrentorganizationId()) {
                                    $html .= " selected ";
                                }
                                $html .= ">" . $organization->getName() ."</option>";
                                echo $html;
                            }
                        ?>
                    </select>
                    <?php } ?>
                </form>
            </li>
        </ul>
      </div><!--/.nav-collapse animate-collapse -->
    </div>
  </div>
  
<?php
//************************************************* CODE BELOW IS JUST FOR PROGRESS SIDE MENU SLIDE/
$request=strtolower($this->uri->segment(2));
$requestDenied=strtolower($this->uri->segment(3));
$controllersAllows=array('event','menu','donationpage','donationpackagegroup','donationpackagedef','sponsor','coupon');
if (isset($event) && is_object($event) && array_search($request, $controllersAllows)!==FALSE && $requestDenied!='active' && $requestDenied!='archived')
{
?>
	<a id="nav-expander" class="nav-expander fixed">
		<i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i> Event <?=$event->getEventProgress()?>%
	</a> 
	<nav>
	<ul class="list-unstyled main-menu">
	  <!-- <li class="text-right close-button text-center"><a href="#" id="nav-close">Close <i class="fa fa-times"></i></a></li> -->
	  <?php
	  /**
	   * @var Model_Eventchecklist
	   */
      if($event->getEventProgress()<100){
    	   $itemList;
    	  foreach(Model_Eventchecklist::getByEventId($event->getId()) as $itemList){
    	  	$feature=Model_Userfeature::getById($itemList->getFeature());
    		if($itemList->getPercentageprogres()<100){
    	  ?>
    	  	<li><a href="<?=base_url($feature->getLink())?>"><?=$feature->getName()?> <span class="badge"><?=$itemList->getPercentageprogres()?>%</span></a></li>
    	  <?
    		}
    	  }
      }else{
          ?>
        <li><a>Your event is already customized and is ready to go.</a></li>  
      <?
      }
	  ?>
	</ul>
</nav>
<? }?>