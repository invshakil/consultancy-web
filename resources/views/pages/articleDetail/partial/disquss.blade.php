<div id="disqus_thread"></div>
<script>
    const disqus_config = function () {
        this.page.url = '{{ url()->current() }}';
        this.page.identifier = '{{ request()->path() }}';
    };

    (function () { // DON'T EDIT BELOW THIS LINE
        const d = document, s = d.createElement('script');
        s.src = 'https://tanventure.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
        Disqus.</a></noscript>
