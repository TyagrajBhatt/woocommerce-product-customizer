<script type="text/html" id="tmpl-mkl-pc-customizer-toolbar">

		<header><button class="cancel close-mkl-pc" type="button"><span><?php _e( 'Cancel' ); ?></span></button></header>
		<section class="choices">
			
		</section>

</script>
<script type="text/html" id="tmpl-mkl-pc-customizer-footer">
	<?php do_action( 'mkl_pc_frontend_customizer_footer_section_left_before' ); ?>
	<div class="footer__section-left">
		<?php do_action( 'mkl_pc_frontend_customizer_footer_section_left_inner_before' ); ?>
			<h3 class="product-name">{{data.name}}</h3>
			<?php do_action( 'mkl_pc_frontend_customizer_footer_section_left_inner_after' ); ?>
		</div>	
		<?php do_action( 'mkl_pc_frontend_customizer_footer_section_right_before' ); ?>
		<div class="footer__section-right">
			<?php do_action( 'mkl_pc_frontend_customizer_footer_form_before' ); ?>
			<div class="form">
			<?php do_action( 'mkl_pc_frontend_customizer_footer_form' ); ?>
			</div>
			<?php do_action( 'mkl_pc_frontend_customizer_footer_form_after' ); ?>
		</div>
</script>