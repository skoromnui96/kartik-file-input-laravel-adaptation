 This is adaptation of kartik-v/bootstrap-fileinput for LARAVEL 5.

1. First thing is go to https://github.com/kartik-v/bootstrap-fileinput
2. Install plugin through composer:
	- composer require kartik-v/bootstrap-fileinput "@dev"
3. You should write migration for image storage.
	- php artisan make:migration create_images_table
4. Create GalleryImage model;
5. Create ImagesController
6. Add routes in web
7. Create ImageService
8. create view and add links in header to libraries that are described on https://github.com/kartik-v/bootstrap-fileinput

If you want use custom helper for image upload path
1. create directory for images
2. create helpers.php in Helpers directory
3. register your helper in register() method of AppServiceProvider 
4. In config filesystems.php add new disk type to store and get images from directory that you want