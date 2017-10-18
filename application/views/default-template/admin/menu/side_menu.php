<div class="cl-sidebar">
	<div class="cl-toggle">
		<i class="fa fa-bars"></i>
	</div>
	<div class="cl-navblock">
		<div class="menu-space">
			<div class="content">
				<?php 
                    echo $gnNavigation->renderActiveMenu();
				?>
			</div>
		</div>
		<div class="text-right collapse-button" style="padding:7px 9px;">
			<!-- <button type="button" class="btn btn-primary" id='intro'>Begin tour</button> -->
			<button id="sidebar-collapse" class="btn btn-default" style="">
				<i style="color:#fff;" class="fa fa-angle-left"></i>
			</button>
		</div>
	</div>
</div>