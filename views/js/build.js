class b{constructor(t,e=e,s=s){this.events={},this.arr=[],this.tEdited,this.pApply,this.document=e,this.window=s,this.targets=t,this.targets.forEach(i=>{const o=Math.random().toString(36).substr(2,9);i.setAttribute("data-id-title",o);let r=i.dataset.attributes;const a=JSON.parse(r);this.arr.push({id:o,html:i,value:i.innerHTML,tag:i.tagName.toLowerCase(),classes:i.classList,focus:this.getAttributeValue(a,"focus"),inside:!1,bold:this.getAttributeValue(a,"bold"),italic:this.getAttributeValue(a,"italic"),underline:this.getAttributeValue(a,"underline"),size:this.getAttributeValue(a,"size")?this.getAttributeValue(a,"size"):32})});for(const i of this.arr){const o=i.id,r=this.document.querySelector('[data-id-title="'+o+'"]');r.setAttribute("contenteditable","true"),i.size=r.style.fontSize}this.toolbar=this.document.createElement("div"),this.toolbar.id="toolbar",this.document.getElementsByTagName("body")[0].appendChild(this.toolbar),this.select=this.document.createElement("select"),this.select.id="select",this.select.innerHTML=`
      <option value="h1">H1</option>
      <option value="h2">H2</option>
      <option value="h3">H3</option>
      <option value="h4">H4</option>
      <option value="h5">H5</option>
      <option value="h6">H6</option>
      <option value="p">p</option>
      <option value="span">span</option>
      `,this.select.selectedIndex=1,this.toolbar.appendChild(this.select),this.size=this.document.createElement("input"),this.size.id="size",this.size.type="number",this.size.value="32",this.size.min="1",this.size.max="100",this.size.step="1",this.toolbar.appendChild(this.size),this.sep=this.document.createElement("div"),this.sep.classList="sep",this.toolbar.appendChild(this.sep),this.B=this.document.createElement("button"),this.Bo=!1,this.B.id="Bold",this.B.innerHTML="B",this.toolbar.appendChild(this.B),this.I=this.document.createElement("button"),this.Io=!1,this.I.id="Italics",this.I.innerHTML="I",this.toolbar.appendChild(this.I),this.U=this.document.createElement("button"),this.Uo=!1,this.U.id="Underline",this.U.innerHTML="U",this.toolbar.appendChild(this.U),this.init(),this.setVisibility()}init(){for(const t of this.arr){let e=this.document.querySelector('[data-id-title="'+t.id+'"]');for(const s of this.targets)this.setBinging(s,t,e);this.select.addEventListener("change",()=>{const s={id:t.id,focus:t.focus,tag:this.select.value,classes:Array.from(e.classList),inside:t.inside,bold:t.bold,italic:t.italic,underline:t.underline,size:t.size},i=structuredClone(s);if(this.tEdited==t.id){let o=e.innerHTML,r=this.select.value,a=this.document.createElement(r);a.innerHTML=o,a.classList=e.classList,e.replaceWith(a);let n=e.getAttribute("data-block-id_prettyblock");a.setAttribute("data-block-id_prettyblock",n);let d=e.getAttribute("data-field");a.setAttribute("data-field",d),e=a,e.setAttribute("data-id-title",t.id),e.setAttribute("contenteditable","true"),t.bold==!0&&(e.style.fontWeight="bold"),t.italic==!0&&(e.style.fontStyle="italic"),t.underline==!0&&(e.style.textDecoration="underline"),e.style.fontSize=t.size+"px",this.setVisibility(),t.html=a,this.change(i,t),this.setBinging(a,t,e)}}),this.size.addEventListener("change",()=>{if(this.tEdited==t.id){const s={id:t.id,focus:t.focus,tag:this.select.value,classes:Array.from(e.classList),inside:t.inside,bold:t.bold,italic:t.italic,underline:t.underline,size:t.size},i=structuredClone(s);e.style.fontSize=this.size.value+"px",t.size=this.size.value,this.change(i,t)}}),this.B.addEventListener("click",()=>{if(this.tEdited==t.id){const s={id:t.id,focus:t.focus,tag:this.select.value,classes:Array.from(e.classList),inside:t.inside,bold:t.bold,italic:t.italic,underline:t.underline,size:t.size},i=structuredClone(s);t.bold==!1?(t.bold=!0,this.B.style.color="#6ae26a",e.style.fontWeight="bold",this.change(i,t)):(t.bold=!1,this.B.style.color="white",e.style.fontWeight="normal",this.change(i,t))}}),this.I.addEventListener("click",()=>{if(this.tEdited==t.id){const s={id:t.id,focus:t.focus,tag:this.select.value,classes:Array.from(e.classList),inside:t.inside,bold:t.bold,italic:t.italic,underline:t.underline,size:t.size},i=structuredClone(s);t.italic==!1?(t.italic=!0,this.I.style.color="#6ae26a",e.style.fontStyle="italic",this.change(i,t)):(t.italic=!1,this.I.style.color="white",e.style.fontStyle="normal",this.change(i,t))}}),this.U.addEventListener("click",()=>{if(this.tEdited==t.id){let s=!t.underline;this.setAttributeValue(e,"underline",s),t.underline=s;const i={id:t.id,focus:t.focus,inside:t.inside,tag:this.select.value,classes:Array.from(e.classList),bold:t.bold,italic:t.italic,underline:t.underline,size:t.size},o=structuredClone(i);t.underline?(this.U.style.color="#6ae26a",e.style.textDecoration="underline"):(this.U.style.color="white",e.style.textDecoration="none"),this.change(o,t)}})}}setBinging(t,e,s){t.getAttribute("data-id-title")==e.id&&t.addEventListener("keydown",i=>{(i.ctrlKey&&i.key=="s"||i.ctrlKey&&i.key=="S"||i.metaKey&&i.key=="s"||i.metaKey&&i.key=="S")&&(i.preventDefault(),e.value=s.innerHTML,this.change(this.pApply,e),t.blur()),i.shiftKey&&i.key=="Enter"?(i.preventDefault(),this.document.execCommand("insertHTML",!1,"<br><br>")):i.key=="Enter"&&(i.preventDefault(),e.value=s.innerHTML,this.change(this.pApply,e),t.blur())})}getAttributeValue(t,e){return t.hasOwnProperty(e)?t[e]:!1}setAttributeValue(t,e,s){let i=t.getAttribute("data-attributes"),o=null;o=JSON.parse(i),o&&o.hasOwnProperty(e)&&(o[e]=s),t.setAttribute("data-attributes",JSON.stringify(o||{}))}setVisibility(){for(const t of this.arr){const e=this.document.querySelector('[data-id-title="'+t.id+'"]');let s=!1,i=!1;e.addEventListener("mousedown",o=>{i=!0,this.toolbar.style.display="flex";const r=o.target.getAttribute("data-id-title"),a=this.arr.filter(d=>d.id==r)[0];this.refreshToolbar(a);const n={id:t.id,focus:t.focus,inside:t.inside,bold:t.bold,tag:this.select.value,italic:t.italic,underline:t.underline,size:t.size,value:o.target.innerHTML};this.pApply=structuredClone(n)}),e.addEventListener("mouseleave",()=>{s=!1,i||setTimeout(()=>{!s&&!i&&(this.toolbar.style.display="none")},1e3)}),e.addEventListener("focus",o=>{i=!0,this.toolbar.style.display="flex";const r=o.target.getAttribute("data-id-title"),a=this.arr.filter(n=>n.id==r)[0];this.refreshToolbar(a)}),e.addEventListener("blur",()=>{i=!1,s||setTimeout(()=>{!s&&!i&&(this.toolbar.style.display="none")},1e3)}),this.toolbar.addEventListener("mouseenter",o=>{s=!0,this.toolbar.style.display="flex"}),this.toolbar.addEventListener("mouseleave",o=>{const r=o.toElement||o.relatedTarget;s=!1,setTimeout(()=>{r&&(r.parentNode===this||r===this||r.parentNode===this.toolbar)||i||(this.toolbar.style.display="none")},1e3)})}}refreshToolbar(t){const e=t.id,s=this.document.querySelector('[data-id-title="'+e+'"]'),i=s.tagName.toLowerCase(),o=this.findTop(s),r=this.findLeft(s),a=Math.round(this.window.getComputedStyle(s,null).getPropertyValue("font-size").split("px")[0]),n=s.getBoundingClientRect(),d=this.toolbar.getBoundingClientRect();this.toolbar.style.top=o-d.height+55+"px",this.toolbar.style.left=r+n.width/2-d.width+"px",this.tEdited=t.id,this.size.value=a,t.size=a,i=="h1"&&(this.select.selectedIndex=0),i=="h2"&&(this.select.selectedIndex=1),i=="h3"&&(this.select.selectedIndex=2),i=="h4"&&(this.select.selectedIndex=3),i=="h5"&&(this.select.selectedIndex=4),i=="h6"&&(this.select.selectedIndex=5),i=="p"&&(this.select.selectedIndex=6),i=="span"&&(this.select.selectedIndex=7),t.bold?this.B.style.color="#6ae26a":this.B.style.color="white",t.italic?this.I.style.color="#6ae26a":this.I.style.color="white",t.underline?this.U.style.color="#6ae26a":this.U.style.color="white"}on(t,e){this.events[t]||(this.events[t]=[]),this.events[t].push(e)}trigger(t,...e){const s=this.events[t];s&&s.forEach(i=>{i(...e)})}change(t,e){t.html=e.html,t.value=e.value,t.classes=e.classes,t.bold=e.bold,t.italic=e.italic,t.underline=e.underline,t.size=e.size,this.trigger("change",t,e)}apply(t,e){!e.inside&&!e.focus&&(t.html=e==null?void 0:e.html,e.value=e.html.innerHTML,this.trigger("apply",t,e))}findTop(t){var e=t.getBoundingClientRect();return e.top+this.window.scrollY}findLeft(t){var e=t.getBoundingClientRect();return e.left+this.window.scrollX}}function y(l){return{name:l.getAttribute("data-zone-name"),alias:l.getAttribute("data-zone-alias")||"",priority:l.getAttribute("data-zone-priority")||!1}}window.hasEventListener=!1;const h=()=>{window.removeEventListener("message",p,!1)},u=()=>({id_lang:prestashop.language.id,id_shop:prestashop.modules.prettyblocks.id_shop,shop_name:prestashop.modules.prettyblocks.shop_name,current_url:prestashop.modules.prettyblocks.shop_current_url,href:window.location.href});let p=l=>{if(l.data.type=="getContext"){let t=u();return l.source.postMessage({type:"setContext",data:{data:t}},"*")}if(l.data.type=="initIframe")return l.source.postMessage({type:"iframeInit",data:null},"*"),c(l);if(l.data.type=="selectBlock"){let t=l.data.data.id_prettyblocks;return g(t,l)}if(l.data.type=="focusOnZone"){let t=l.data.data;document.querySelectorAll(".border-dotted").forEach(s=>{s.classList.remove("border-dotted")});let e=document.querySelector('[data-prettyblocks-zone="'+t+'"]');return e.classList.add("border-dotted"),e.scrollIntoView({alignToTop:!0,behavior:"smooth",block:"center"})}if(l.data.type=="updateHTMLBlock"){let t=l.data.data.id_prettyblocks,e=l.data.data.html,s=document.querySelector('[data-id-prettyblocks="'+t+'"]');return s.innerHTML=e,c(l)}if(l.data.type=="scrollInIframe")return f(l.data.data);if(l.data.type=="getZones"){let t=document.querySelectorAll("[data-zone-name]"),e=[];return t.forEach(s=>{let i=s.getAttribute("data-zone-name"),o={name:s.getAttribute("data-zone-name"),alias:s.getAttribute("data-zone-alias")||"",priority:s.getAttribute("data-zone-priority")||"false"};e.indexOf(i)==-1&&e.push(o)}),l.source.postMessage({type:"zones",data:e},"*")}h()};const g=(l,t)=>{let s=f(l).closest("[data-prettyblocks-zone]").getAttribute("data-prettyblocks-zone"),i=y(document.getQuerySelector('[data-zone-name="'+s+'"]')),o={id_prettyblocks:l,zone:i};return t.source.postMessage({type:"focusBlock",data:o},"*")},f=l=>{let t=document,e=t.querySelector('[data-id-prettyblocks="'+l+'"]');return t.body.contains(e)&&!e.classList.contains("border-dotted")&&(e.scrollIntoView({alignToTop:!1,behavior:"smooth",block:"center"}),t.querySelectorAll("[data-block]").forEach(i=>{i.classList.remove("border-dotted")}),e.classList.add("border-dotted")),e},c=l=>{new b(document.querySelectorAll(".ptb-title"),document,window).on("change",async e=>{let s={id_prettyblocks:e.html.closest("[data-id-prettyblocks]").getAttribute("data-id-prettyblocks"),field:e.html.getAttribute("data-field"),index:e.html.hasAttribute("data-index")?e.html.getAttribute("data-index"):null};l.source.postMessage({type:"updateTitleComponent",data:{params:s,value:JSON.stringify(e)}},"*")})};document.addEventListener("DOMContentLoaded",l=>{window.hasEventListener||(window.addEventListener("message",p,!1),window.hasEventListener=!0),document.querySelectorAll("a").forEach(e=>{e.addEventListener("click",function(s){s.preventDefault();const i=s.currentTarget.href;let r={context:u(),url:i};window.parent.postMessage({type:"setNewUrl",params:r},"*")})})});h();
