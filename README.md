# YouTube search API

A simple website for browsing videos, using the YouTube API.

## Challenge
> Build an MVC application using PHP and a popular framework  which will use the YouTube API on the server side to return a list of YouTube search results by an Ajax call.
>
> Some coding restrictions:
> 
> 1. The code should be created using any popular PHP framework such as Zend Framework 3, Laravel or Symfony and follow their best practices for code styling.
> 2. The code submission must be done by sending through a git repository with at least two commits:
> 3. Showing the basic framework and library installation with no modifications
> 4. Showing the application being built and committed without any basic framework setup, this may be done on several commits if desired showing clear progression in building the app.
>
> The frontend isn't a focus point of this, however it should be presentable and usable in whichever way you seem fit.

## Set up
The site can be set up by placing the code in the site root.

A YouTube API key is also necessary. See [https://developers.google.com/youtube/v3/getting-started](https://developers.google.com/youtube/v3/getting-started) for how to get an API key.

The code does not include the Laravel `.env` file. This can be created by copy-pasting the `.env.example` file and ensuring a YouTube API key is set ensure a value for `YOUTUBE_API_KEY` is set in the file. e.g. `YOUTUBE_API_KEY=API_KEY_GOES_HERE`.

## Functions

The api URL`/admin/api/search?keyword=&token=&type=` can be used to fetch data.
* `keyword` - term to search
* `token` - identifier for a specific page of results
* `type` - comma separate list of types of results to return (videos, channels, playlists), if empty searches everything

The site frontend may also be used a GUI for searching videos, channels and playlists either. Use the form fields to enter search criteria. Use the previous and next buttons to navigate through pages of results.

## Languages and libraries used

This is a website, using HTML, CSS, JavaScript and PHP.

Libraries include:
* [Laravel](https://laravel.com/) v8
* [Twitter Bootstrap](https://getbootstrap.com/) v4.0.0
* [Vue.js](https://vuejs.org/) v2.6.11
* [Axios](https://github.com/axios/axios) v0.19.2

