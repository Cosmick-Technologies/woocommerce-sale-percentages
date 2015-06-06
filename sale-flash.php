<?php
	global $post, $product;

	if (strpos($product->get_categories(), 'New Products')) {
		echo(apply_filters('woocommerce_sale_flash', '<span class="on-new">' . __('New!', 'woocommerce') . '</span>', $post, $product));
	}

	if ($product->is_on_sale()) {
		$SALE_HTML = '<span class="on-sale">';

		if ($product->product_type == 'variable') {
			$VARIATIONS = $product->get_available_variations();
			$MAX_PERCENTAGE = 0;

			for ($i=0; $i < count($VARIATIONS); $i++) {
				$PERCENTAGE = round((($VARIATIONS[$i]['display_regular_price'] - $VARIATIONS[$i]['display_price']) / $VARIATIONS[$i]['display_regular_price']) * 100);

				if ($PERCENTAGE > $MAX_PERCENTAGE) {
					$MAX_PERCENTAGE = $PERCENTAGE;
				}
			}

			$SALE_HTML .= sprintf(__('Save %s', 'woocommerce'), $MAX_PERCENTAGE . '%');
		} else if ($product->product_type == 'simple') {
			$MAX_PERCENTAGE = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
			$SALE_HTML .= sprintf(__('Save %s', 'woocommerce'), $MAX_PERCENTAGE . '%');
		}

		$SALE_HTML .= '</span>';

		if ($MAX_PERCENTAGE > 0) {
			echo(apply_filters('woocommerce_sale_flash', $SALE_HTML, $post, $product));
		}
	}