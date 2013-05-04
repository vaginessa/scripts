<html>
  <head>
    <title>Photo Sphere Viewer &amp; Picasa Web Albums Data API</title>
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    <style>
    body {
      font-family: "Droid Sans", Helvetica, Arial, sans-serif; 
      background: #EEE
    }
    h1 {
      font-size: 1.5em;
    }
    h2 {
      font-size: 1.1em;
    }
 
    #userEmail, #albumSelect {
      width: 200px;
      border: 1px solid gray;
    }
    #thumbnailContainer {
      background: #ccc;
      overflow: auto;
      white-space: nowrap;
    }
    #thumbnailContainer img {
      margin: 4px;
      cursor: pointer;
    }
    #thumbnailContainer img:hover {
      transform: scale(1.1);
      -webkit-transform: scale(1.1);
      -moz-transform: scale(1.1);
    }

    </style>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  </head>
  <body>
    <h1>Photo Sphere Viewer &amp; Picasa Web Albums Data API</h1>
    <h2>1. Enter Google user's email address or user ID.</h2>
    <input id="userEmail" type="text"/>
    <input id="submitUserEmail" type="submit" value="OK"/>
    <input id="getAllPanos" type="submit" value="Get all (experimental)"/>

    <h2>2. Choose album to search for photo spheres</h2>
    <select id="albumSelect">
    </select>

    <h2>3. Choose a photo sphere to display</h2>
    <div id="thumbnailContainer">
    </div>

	<h2>4. Code to include</h2>
    <div id="codeContainer">
	</div>
	
	<h2>5. Embedded panorama view</h2>
    <div id="viewerContainer">
    </div>

    <script>
      var FEED_SCHEMA = 'http://schemas.google.com/g/2005#feed';
 
      // Fetch all albums for a given user. Parameter 'user' should either be
      // the email address or user ID.
      function fetchAlbumsFor(user, searchForPanos) {
        $('#getAllPanos').attr('disabled', '');
        $('#thumbnailContainer').empty();

        var baseURL = 'https://picasaweb.google.com/data/feed/api/user/';        
        var url = baseURL + user + '?v=4&alt=json';
        $.getJSON(url, function(response) {
          if (!response || !response.feed || !response.feed.entry) {
            alert('Data invalid.');
            return;
          }

          // Remove all previous dropdown elements.
          $('#albumSelect').empty();

          // Add albums to dropdown element.
          $('#albumSelect').append($('<option></option>')
                           .attr('value', '')
                           .text('<Select an album>'));
          $.each(response.feed.entry, function(index, entry) {
            var feedUrl = getFeedUrl(entry);
            $('#albumSelect').append($('<option></option>')
                             .attr('value', feedUrl)
                             .text(entry.title.$t));
            if (searchForPanos) {
              fetchPhotos(feedUrl, false);
            }
          });
          $('#getAllPanos').removeAttr('disabled');
        }).fail(function() {
          alert('Could not fetch data.');
        });
      }

      // Returns the feed URL of an entry.
      function getFeedUrl(entry) {
        for(var i = 0; i < entry.link.length; ++i) {
          if (entry.link[i].rel == FEED_SCHEMA) {
            return entry.link[i].href;
          }
        }
        return '';
      }

      // Returns whether the given entry is a photo sphere.
      function isPhotoSphere(entry) {
        if (!entry.gphoto$streamId) {
          return false;
        }
 
        var streamIds = entry.gphoto$streamId;
        for (var i = 0; i < streamIds.length; ++i) {
          if (streamIds[i].$t == "photosphere") {
            return true;
          }
        }
        return false;
      }

      // Fetches the feed data for a photo sphere based on the given feed URL
      // and displays the photo sphere given the returned metadata.
      function displayPhotoSphere(panoFeedUrl) {
        $('#viewerContainer').empty();

        // Request the full exif of the photo sphere, which contains the
        // metadata we need to properly display it.
        $.getJSON(panoFeedUrl + '&full-exif=true', function(response) {
          if (!response || !response.feed || !response.feed.exif$tags) {
            return;
          }

          // Extract the required metadata.
          var exif = response.feed.exif$tags;
          $('#viewerContainer')
              .append($('<g:panoembed></g:panoembed>')
              .attr('imageurl',
                    response.feed.media$group.media$content[0].url)
              .attr('fullsize',
                    exif.exif$FullPanoWidthPixels.$t + ',' +
                    exif.exif$FullPanoHeightPixels.$t)
              .attr('croppedsize',
                     exif.exif$CroppedAreaImageWidthPixels.$t + ',' +
                     exif.exif$CroppedAreaImageHeightPixels.$t)
              .attr('offset',
                     exif.exif$CroppedAreaLeftPixels.$t + ',' +
                     exif.exif$CroppedAreaTopPixels.$t)
              .attr('displaysize', '500,375')
          );
          
          //get param
          image_url = response.feed.media$group.media$content[0].url;
          fullsize = exif.exif$FullPanoWidthPixels.$t + ',' + exif.exif$FullPanoHeightPixels.$t
          croppedsize = exif.exif$CroppedAreaImageWidthPixels.$t + ',' + exif.exif$CroppedAreaImageHeightPixels.$t;
          offset = exif.exif$CroppedAreaLeftPixels.$t + ',' + exif.exif$CroppedAreaTopPixels.$t;

			$.get('generate.php?image_url='+image_url+'&fullsize='+fullsize+"&croppedsize="+croppedsize+"&offset="+offset, function(data) {
			  $('#codeContainer').html(data);
			});

          // Searches the whole DOM tree for g:panoembed elements and
          // initializes them.
          gapi.panoembed.go();
        });
      }

      // Fetches photos, filters photo spheres and displays them.
      function fetchPhotos(url, removePrevious) {
        $.getJSON(url, function(response) {
          if (!response || !response.feed || !response.feed.entry) {
            return;
          }

          // Add the thumbnails to the container and hook up the click
          // listeners.
          if (removePrevious) {
            $('#thumbnailContainer').empty();
          }
          $.each(response.feed.entry, function(index, entry) {
            if (isPhotoSphere(entry)) {
              $('#thumbnailContainer')
                  .append($('<img></img>')
                  .attr('src', entry.media$group.media$thumbnail[1].url)
                  .attr('panoFeedUrl', getFeedUrl(entry))
                  .click(function() {
                displayPhotoSphere($(this).attr('panoFeedUrl'));
              }));
            }
          });
        });
      }

      // Fetch JSON for user if the OK button is clicked or the user hits the
      // enter key in the input field.
      $('#submitUserEmail').click(function() {
        fetchAlbumsFor($('#userEmail').val(), false);
      });
      $('#userEmail').bind('keypress', function(e) {
        // Fetch if enter key was pressed.
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
          fetchAlbumsFor($('#userEmail').val(), false);
        }
      });

      // Fetch the photo spheres when the user selects an album.
      $('#albumSelect').change(function() {
        fetchPhotos($('#albumSelect').val(), true);
      });
      $('#getAllPanos').click(function() {
        fetchAlbumsFor($('#userEmail').val(), true);
      });
    </script>
  </body>
</html>
