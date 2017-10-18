
<?php $userId = 1;?>

  <!-- Fixed navbar -->
  <div id="head-nav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="fa fa-gear"></span>
        </button>
        <a class="navbar-brand" href="#"><span>Clean Zone</span></a>
      </div>
      <div class="navbar-collapse collapse">

    <ul class="nav navbar-nav navbar-right user-nav">
      <li class="dropdown profile_menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img alt="Avatar" src="<?= panel_url('images/avatar2.jpg')?>" /><span>Jeff Hanneman</span> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/user/profile/<?php echo $userId; ?>">My Profile</a></li>
          <li class="divider"></li>
          <li><a href="/user/logout">Sign Out</a></li>
        </ul>
      </li>
    </ul>
      </div><!--/.nav-collapse animate-collapse -->
    </div>
  </div>