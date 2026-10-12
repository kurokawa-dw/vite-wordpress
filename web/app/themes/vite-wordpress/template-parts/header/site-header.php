 <header class="site-header">
     <a class="site-header__brand" href="<?php echo esc_url(home_url('/')); ?>">
         <?php bloginfo('name'); ?>
     </a>

     <nav>
         <ul>
             <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
             <li><a href="<?php echo esc_url(home_url('/products/')); ?>">Products</a></li>
             <li><a href="<?php echo esc_url(home_url('/order/')); ?>">Order</a></li>
             <li><a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>">Notebook</a></li>
             <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
         </ul>
     </nav>
 </header>
