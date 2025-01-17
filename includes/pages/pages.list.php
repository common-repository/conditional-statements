<?php

defined('ABSPATH') or die('Jog on!');

function yk_cs_conditions_page() {

	?>

	<div class="wrap">

		<div id="icon-options-general" class="icon32"></div>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-3">

				<!-- main content -->
				<div id="post-body-content">

					<div class="meta-box-sortables ui-sortable">
						<div class="postbox">
							<h3 class="hndle"><span>Conditions</span></h3>
							<div style="padding: 0px 15px 0px 15px">
                                <br />
								<?php echo yk_cs_display_conditions(); ?>
								<br />
								<p><?php echo __('<strong> Suggestion?</strong> Got an idea for a condition? If so, email me at: ') . '<a href="mailto:email@yeken.uk">email@yeken.uk</a>'; ?> </p>
							</div>
						</div>


					</div>
					<!-- .meta-box-sortables .ui-sortable -->
				</div>
				<!-- post-body-content -->
			</div>
			<!-- #post-body .metabox-holder .columns-2 -->
			<br class="clear">
		</div>
		<!-- #poststuff -->

	</div> <?php

}
