@extends('layouts.site')

@section('title')
    Search YouTube
@endsection

@section('content')
    <div class="container" id="app">
        <div class="row mt-4">
            <div class="col-sm-6">
                {{-- Keyword input. Binded to the app's "keyword" member. Changing this will update search results. --}}
                <label class="input-group mb-3">
                    <span class="input-group-prepend">
                        <span class="input-group-text" id="filters-keyword-addon">
                            <span class="sr-only">Search</span>
                            <span class="fa fa-search"></span>
                        </span>
                    </span>

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search"
                        aria-label="Keyword"
                        aria-describedby="filters-keyword-addon"
                        v-model="keyword"
                        v-on:change="getResults"
                    />
                </label>
            </div>

            <div class="col-sm-6">
                {{-- Type input. Binded to the app's "type" member. Changing this will update search results. --}}
                <label class="sr-only" for="filters-type">Type</label>

                <select class="form-control" id="filters-type" v-model="type" v-on:change="getResults">
                    <option value="">Type (all)</option>
                    <option value="video">Videos</option>
                    <option value="channel">Channels</option>
                    <option value="playlist">Playlists</option>
                </select>
            </div>
        </div>

        {{-- If any error messages are encounterd, they will appear here. --}}
        <div class="search-error" v-if="errorMessage" v-html="errorMessage"></div>

        {{-- If there are no errors, show the search results --}}
        <div class="search-wrapper" v-if="!errorMessage">
            {{-- Number of records found --}}
            <div v-if="search.pageInfo">Results found: <span v-html="search.pageInfo.totalResults.toLocaleString()"></span></div>

            {{-- List of results, using the `youtube-result` template --}}
            <div class="search-results">
                <youtube-result v-for="result in results" v-bind:result="result"></youtube-result>
            </div>

            {{-- Pagination buttons --}}
            <div class="search-pagination text-center mb-4 clearfix" v-if="results.length">
                {{-- Clicking "previous" will open the previous page of results. The button will be disabled if this is the first page. --}}
                <button
                    type="button" class="btn float-left"
                    :disabled="!search.prevPageToken" v-on:click="changePage(search.prevPageToken)"
                >
                    <span class="fa fa-arrow-left"></span>
                    Previous
                </button>

                {{-- Clicking "next" will open the next page of results. The button will be disabled if this is the last page. --}}
                <button
                    type="button" class="btn float-right"
                    :disabled="!search.nextPageToken" v-on:click="changePage(search.nextPageToken)"
                >
                    Next
                    <span class="fa fa-arrow-right"></span>
                </button>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script src="/js/scripts.js"></script>
@endsection