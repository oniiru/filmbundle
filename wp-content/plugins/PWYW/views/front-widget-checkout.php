<h1>Checkout out widget</h1>

<h2>Pubnub test</h2>
<script src='http://cdn.pubnub.com/pubnub-3.5.3.min.js'></script>
<script type="text/javascript" >
jQuery(document).ready(function($) {
    var pubnub = $.PUBNUB.init({
        subscribe_key : 'sub-c-ef114922-f1ea-11e2-b383-02ee2ddab7fe'
    });

    pubnub.subscribe({
        channel : 'filmbundle',
        message : function(m){
            console.log(m);
            $('#pubnub-server').text(m.server);
            $('#pubnub-time').text(m.server_time);
        }
    })
});
</script>

<p>Latest pubnub update<br/>
(refresh any page in admin, for a new pubhub to be pushed)<br/>
From server: <span id='pubnub-server'></span><br/>
At server time: <span id='pubnub-time'></span><br/>
</p>