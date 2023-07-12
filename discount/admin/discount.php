<h1>Discount</h1>
<br>
<div>
    <div class="my-form">
        <form name="discountform" method="POST" action="<?php admin_url('admin.php');?>">
            <input type="hidden" name="page" value="discountPage">
            <label for="discount">Discount Percentage : </label>
            <input type="number" name="discount" id="discount">
            <input type = "submit" value="submit" name="submit" >
            <p id="message"></p>
        </form>
    </div>
<div>


<?php

    if (isset($_POST['discount'])){
        $discount = floatval($_POST['discount']);
        if ($discount != NULL and $discount >= 0 and $discount <= 100  ){

            global $wpdb ;

            $posts = $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_type = 'product' AND post_title !='AUTO-DRAFT'");

            foreach ($posts as $post) {
                
                if (get_post_meta($post->ID,"WooDiscount") == NULL) {
                    add_post_meta($post->ID,"WooDiscount",$discount);
                }
                else {
                    update_post_meta( $post->ID, "WooDiscount", $discount );
                }

                $product = wc_get_product($post->ID);



                switch($product->get_type()){
                    case 'simple' :
                        $regular = get_post_meta($post->ID,"_regular_price");
                        $regularPrice = 0 ;
                        foreach ($regular as $i){
                            $regularPrice = $i; 
                        }
                        $salePrice = $regularPrice - round($regularPrice*$discount/100);
                        update_post_meta($post->ID,"_price",$salePrice);
                        update_post_meta($post->ID,"_sale_price",$salePrice);
                        break;
                    
                    case 'variable': 
                        $variations  = $product->get_children();
                        foreach ($variations as $variation){
                            $regular = get_post_meta($variation,"_regular_price");
                            $regularPrice = 0 ;

                            foreach ($regular as $i){
                                $regularPrice = $i; 
                            }
                            $salePrice = $regularPrice - round($regularPrice*$discount/100);
                            update_post_meta($variation,"_price",$salePrice);
                            update_post_meta($variation,"_sale_price",$salePrice);
                            
                        }
                        update_post_meta($post->ID,"_price",$salePrice);
                        
                        break;

                }

            }
        }
        else {
            echo "<p>enter proper discount persentage </p>";
        }


        
        
    }










?>