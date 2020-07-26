/* Vue template for a search result */
Vue.component('youtube-result', {

    /*
     * "Result" is an object containing data for a single search result
     ** `url`         - link to the result found
     ** `thumbnails`  - list of image thumbnails for each size, with their URLS and dimensions
     ** `title`       - name of the result
     ** `description` - summary of the result
     */
    props: ['result'],

    template: `<div class="search-result border clearfix my-3 d-flex">
            <div class="search-result-thumbnail text-center">
                <a :href="result.url" tabindex="-1">
                    <img
                        v-if="result.thumbnails && result.thumbnails.medium"
                        :src="result.thumbnails.medium.url"
                        :width="result.thumbnails.medium.width"
                        :height="result.thumbnails.medium.height"
                        alt=""
                     />
                </a>
            </div>

            <div class="search-result-details p-3">
                <h3>{{ result.title }}</h3>

                <p>{{ result.description }}</p>

                <a :href="result.url">{{ result.url }}</a>
            </div>
        </div>`,
    data() {
        return {
            result: {}
        }

    }
});

var vm = new Vue({
    el: '#app',
    data: {
        // Default data used by the application
        errorMessage: '',  // Text to show if there is a problem retrieving results
        keyword: '',       // Term searched by the user
        pageToken: null,   // Identifier used for getting a specific set of results (typically used with pagination)
        results: [],       // Array of objects for each search result
        search: {},        // Object containing data relevant to the search
        status: '',        // Status of the API request; loading, done, error
        token: '',         // Identifier used for getting a specific set of results (typically used with pagination)
        type: '',          // Filter for controlling types of results returned (videos, channels, playlists)
    },

    // When the app initialises, run the function for getting results.
    created: function() {
        this.getResults()
    },

    methods: {
        // Fetches search results from the API.
        getResults: function() {
            this.status = 'loading';

            let vm = this;

            // Gather data to be used in the API query.
            const params = new URLSearchParams({
                keyword: vm.keyword,
                token: vm.token,
                type: vm.type
            });

            if (!vm.keyword) {
                // If there is no keyword, just return no results. Cheaper than making an API call.
                vm.status = 'done';
                vm.results = [];
                vm.search = {};
            } else {
                // Fetch data from the server
                axios.get('/api/search?' + params.toString())
                    .then(response => {
                        if (!response.data.search.error) {
                            // If the server encounters no error
                            // mark as successful and update the search result data
                            vm.status       = 'done';
                            vm.results      = response.data.results;
                            vm.search       = response.data.search;
                            vm.errorMessage = '';
                        } else {
                            // Otherwise set the error message
                            vm.status = 'error';
                            vm.errorMessage = response.data.search.error.message;
                        }
                    })
                    .catch(ex => {
                        // If the server encounters an exception error, display a message.
                        vm.status = 'error';
                        vm.errorMessage = 'Error connecting to the API.';
                        console.log(ex);
                    });
            }
        },
        // Load a specific page of results, using a page token.
        changePage(token) {
            // Set the token and make the API call again.
            this.token = token;
            this.getResults();

            // Scroll back to the top of the search results.
            document.getElementById('app').scrollIntoView();
        }
    }
});
