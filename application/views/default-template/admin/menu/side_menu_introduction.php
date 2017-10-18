<?php
//TODO: Retrieve the session object;

$contentView;

$pathArray = explode("/", $contentView);
$selectedMenu = $pathArray[0];
$typeMenu = $pathArray[1];
?>

<div class="cl-sidebar" data-position="right" data-step="1" data-intro="<strong>Fixed Sidebar</strong> <br/> It adjust to your needs." >
	<div class="cl-toggle">
		<i class="fa fa-bars"></i>
	</div>
	<div class="cl-navblock">
		<div class="menu-space">
			<div class="content">
				<ul class="cl-vnavigation">
						<?php if ($typeMenu=='index' )
								{
						?>
							<li class="active">
								<a href="/<?php echo $selectedMenu; ?>/"><i class="fa fa-table"></i><span><?php echo $selectedMenu; ?></span></a>
							</li>
							<?php
								}
								else
								{
							?>
							<li <?php echo ($typeMenu === "actived" ? "class=\"active\"" : "");?> >
								<a href="/<?php echo $selectedMenu; ?>/actived/"><i class="fa fa-table"></i><span>Actived</span></a>
							</li>
							<li <?php echo ($typeMenu === "archived" ? "class=\"active\"" : "");?> >
								<a href="/<?php echo $selectedMenu; ?>/archived/"><i class="fa fa-table"></i><span>Archived</span></a>
							</li>
							<?php } ?>


				</ul>
			</div>
		</div>
		<div class="text-right collapse-button" style="padding:7px 9px;">
			<input type="text" class="form-control search" placeholder="Search..." />
			<button id="sidebar-collapse" class="btn btn-default" style="">
				<i style="color:#fff;" class="fa fa-angle-left"></i>
			</button>
		</div>
	</div>
</div>