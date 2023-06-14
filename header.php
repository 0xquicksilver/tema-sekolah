<?php
    $locations = get_nav_menu_locations();
    $menu_id = $locations['primary'];
    $menu_items = wp_get_nav_menu_items($menu_id);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title(); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {}
        }
      }
    }
  </script>
  <?php wp_head(); ?>
</head>
<body class="container-snap overflow-auto bg-slate-800">
    <div class="flex flex-col min-h-full">
        <nav class="relative px-4 py-4 flex justify-between items-center">
            <a class="text-md md:text-lg lg:text-3xl font-bold leading-none uppercase text-slate-100" href="<?php bloginfo('url'); ?>">
                <?php bloginfo('name'); ?>
            </a>
            <div class="lg:hidden">
                <button class="navbar-burger flex items-center text-blue-600 p-3">
                    <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Mobile menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </button>
            </div>
            <ul class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto lg:items-center lg:w-auto lg:space-x-6">
                <?php if (!empty($menu_items)) { foreach ($menu_items as $menu_item) { ?>
                <li><a class="text-sm text-slate-400 hover:text-gray-500" href="<?php echo $menu_item->url; ?>">
                        <?php echo $menu_item->title; ?>
                    </a></li>
                <li class="text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-4 h-4 current-fill" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v0m0 7v0m0 7v0m0-13a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </li>
                <?php } } ?>
            </ul>
            <a class="hidden lg:inline-block py-2 px-6 bg-blue-500 hover:bg-blue-600 text-sm text-white font-bold rounded-xl transition duration-200" href="<?php echo bloginfo('url') . '/pendaftaran'; ?>">Pendaftaran</a>
        </nav>
        <div class="navbar-menu relative z-50 hidden">
            <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
            <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-slate-800 border-r overflow-y-auto">
                <div class="flex items-center mb-8">
                    <a class="mr-auto text-2xl font-bold leading-none text-white" href="<?php bloginfo('url'); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                    <button class="navbar-close">
                        <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div>
                    <ul>
                    <?php if (!empty($menu_items)) { foreach ($menu_items as $menu_item) { ?>
                        <li class="mb-1">
                            <a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-blue-50 hover:text-blue-600 rounded" href="<?php echo $menu_item->url; ?>"><?php echo $menu_item->title; ?></a>
                        </li>
                    <?php } } ?>
                    </ul>
                </div>
                <div class="mt-auto">
                    <div class="pt-6">
                        <a class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-blue-600 hover:bg-blue-700 rounded-xl" href="<?php echo bloginfo('url') . '/pendaftaran'; ?>">Pendaftaran</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</body>
</html>
