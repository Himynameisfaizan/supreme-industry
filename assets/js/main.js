(function(){
  var $=function(s,c){return(c||document).querySelector(s)},$$=function(s,c){return[].slice.call((c||document).querySelectorAll(s))};
  // header shadow + mobile menu
  var h=$('#hdr'),nav=$('#nav'),bg=$('#burger');
  addEventListener('scroll',function(){h.classList.toggle('sc',scrollY>8)},{passive:true});
  bg.addEventListener('click',function(){var o=nav.classList.toggle('open');bg.setAttribute('aria-expanded',o)});
  $$('#nav a').forEach(function(a){a.addEventListener('click',function(){nav.classList.remove('open');bg.setAttribute('aria-expanded',false)})});

  // hero crossfade slider
  var hs=$('#heroSlider');
  if(hs){var im=$$('img',hs),i=0,now=$('#hsNow');
    if(im.length>1)setInterval(function(){im[i].classList.remove('on');i=(i+1)%im.length;im[i].classList.add('on');now.textContent=i+1},5000)}

  // scroll-snap sliders (+ dots)
  $$('[data-slider]').forEach(function(t){
    var box=t.parentNode,step=function(){var c=t.firstElementChild;return c?c.getBoundingClientRect().width+16:300};
    var p=$('[data-prev]',box),n=$('[data-next]',box);
    if(n)n.onclick=function(){t.scrollLeft+step()>=t.scrollWidth-t.clientWidth-4?t.scrollTo({left:0,behavior:'smooth'}):t.scrollBy({left:step(),behavior:'smooth'})};
    if(p)p.onclick=function(){t.scrollBy({left:-step(),behavior:'smooth'})};
    var db=$('[data-dotbox]',box);
    if(db){var kids=[].slice.call(t.children);
      kids.forEach(function(k,x){var d=document.createElement('i');d.onclick=function(){t.scrollTo({left:k.offsetLeft-t.offsetLeft,behavior:'smooth'})};db.appendChild(d)});
      var upd=function(){var x=Math.round(t.scrollLeft/step());$$('i',db).forEach(function(d,j){d.classList.toggle('on',j===x)})};
      t.addEventListener('scroll',upd,{passive:true});upd()}
  });

  // reveal + count-up
  var cnt=function(el){var to=parseFloat(el.dataset.count),s=el.dataset.suffix||'',t0=performance.now();
    (function f(t){var k=Math.min((t-t0)/1400,1),v=to*(1-Math.pow(1-k,3));el.textContent=(to%1?v.toFixed(1):Math.round(v))+s;if(k<1)requestAnimationFrame(f)})(t0)};
  if(!('IntersectionObserver' in window)){$$('.rv').forEach(function(e){e.classList.add('in')});$$('[data-count]').forEach(cnt);return}
  var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add('in');$$('[data-count]',e.target).forEach(cnt);io.unobserve(e.target)}})},{threshold:.15});
  $$('.rv').forEach(function(e){io.observe(e)});
})();
