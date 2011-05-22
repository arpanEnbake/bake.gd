window.addEvent('domready',function(){
    var hero_wrapper = $('hero-container');
    if (Browser.Engine.trident && Browser.Engine.version <= 4){
        hero_wrapper.setStyle('display','none');
        $('content-home').setStyle('paddingTop',25);
    }
    var heroes = $$('div.hero-wrapper');
    heroes.setStyles({
        'position' : 'absolute',
        'top' : 0,
        'left' : 0
    });
    var one = heroes.shift();
    var hero_bottom = hero_wrapper.getStyle('height');
    heroes.setStyle('top',hero_bottom);
    var hero_frames = $('hero-frames');
    var hero_frames_a = hero_frames.getElements('a');
    var interval;
    var time = 5000;
    
    var click_next_active_a = function(use_1){
        //alert(use_1);
        var nxt;
        hero_frames_a.each(function(e){
            var n = e.get('href').replace('#','');
            if (e.hasClass('frame-' + n + '-active')){
                // try to get next
                nxt = $(document.body).getElement('.frame-' + (n.toInt() + 1).toString());
                if (!nxt || use_1) nxt = $(document.body).getElement('.frame-1');
            }
        });
        nxt.fireEvent('click');
    }

    var hero_click = function(){
        $clear(interval);
        var n = this.get('href').replace('#','');
        if (this.hasClass('frame-' + n + '-active')) return false;
        hero_frames_a.each(function(a){
            var n1 = a.get('href').replace('#','');
            a.set('class','frame-' + n1);
        });
        this.set('class','frame-' + n + '-active');
        one.set('tween',{duration:400,onComplete : function(){
                // get the new element
                // animate it up
                // set it as one at the end
                var up = $('hero-' + n);
                up.set('tween',{duration:400}).tween('top',0);
                one = up;
                interval = click_next_active_a.delay(time,hero_wrapper,[false]);
            }.bindWithEvent(this)
        }).tween('top',hero_bottom);
        return false;
    }

    hero_frames_a.addEvent('click',hero_click);
    interval = click_next_active_a.delay(time,hero_wrapper,[false]);
});
