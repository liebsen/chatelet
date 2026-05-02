<style>
:root {
  --box-shadow: rgba(0, 0, 0, 0.2) 0 0 6px;
  --box-dropshadow: 0 -2px 5px rgba(0, 0, 0, 0.15);
  --box-shadow-inset: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
  --box-shadow-downwards: rgba(0, 0, 0, 0.05) 0px 4px 8px -1px, rgba(0, 0, 0, 0.05) 0px 2px 3px -1px;
  --google-fonts-name: <?=@$settings['google_font_name'] ?>;
}

html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video { 
  margin: 0; 
  padding: 0; 
  border: 0;  
  font-size: 100%;
  font-weight: 300;
  vertical-align: baseline; 
}

html, body { 
  font-family: '<?=@$settings['google_font_name'] ?>', Verdana, Arial, Sans-Serif!important;
  line-height: 1;
  font-size: 100%!important; 
}

ol, ul { list-style: none; }

p { 
  margin-bottom: 10px; 
  font-weight: 300;
}

pre, code {
  color: #545454;
  background-color: #f1f1f1;
  padding: 1rem;
  display: inline-block;
  text-indent: 0;
}

table { border-collapse: collapse; border-spacing: 0; }

caption, th, td { text-align: left; font-weight: normal; vertical-align: middle!important; font-weight: 300; }

q, blockquote { quotes: none; }
q:before, q:after, blockquote:before, blockquote:after { content: ""; content: none; }

a img { border: none; }

article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary { display: block; }

* { outline: none; }

a, a:hover, a:active, a:focus, a:visited { cursor: pointer; text-decoration: none }

/* responsiveness */

.mobile, .desktop {
  display: none;
}

@media screen and (max-width:991px), print {
  .mobile {
    display: inline-block;
  }
  .desktop {
    display: none!important;
  }
}

@media screen and (min-width:992px), print {
  .mobile {
    display: none!important;
  }
  .desktop {
    display: inline-block;
  }        
}

@media (prefers-color-scheme: dark) {
  ::placeholder {
    color: #888!important;
  }
  html, 
  body, 
  h1, 
  h2, 
  h3, 
  h4, 
  h5, 
  h6, 
  p,
  a,
  .category-content,
  li {
    &:not(.box *):not([class*="text-"]) {
      color: #f8f8f8!important;
      border-color: #666!important;
      &:hover {
        color: #666;
      }
    }
  }
  .label,
  .tab-content {
    &:not(.scheme-preserve) {
      color: #f8f8f8;
      &:hover {
        color: #888;
      }
    }
  }

  html,
  body,
  #main,
  blockquote,
  footer,
  .select select, 
  .block-tabs > .nav-tabs > li > a, 
  .pagination > .disabled > a, 
  .toggle-label,
  .carrito-selector,
  .list-group-item,
  .form-control,
  .navbar-chatelet,
  .dropdown-menu,
  .nav-tabs,
  .card,  
  .shop-options,  
  .table,
  .table tr,
  .table td,
  .table th {
    color: #f8f8f8;
    background-color: #000!important;
    border-color: #888!important;
  }
  .btn {
    &:not([class*="btn-"]):not(.borderless) {
      background-color: #222;
      border-color: #666;
      &:hover {
        background-color: #333;
        color: #888!important;
      }
    }
  }

  .btn.is-text:hover, .btn.is-text.is-hovered, .btn.is-text:focus, .btn.is-text.is-focused {
    background-color: #333;
    color: #888!important;    
  }

  .form-control:focus,
  .btn-chatelet,
  nav.sidebar,
  .bg-light,
  .tab-content,
  .nav-tabs,
  .toggle-label,
  .switch-scale {
    background-color: #444!important;
  }
  .price_strong,
  .name {
    color: whitesmoke!important;
  }
  .navbar-brand {
    background-image: url(/images/logo-w.png)!important; 
  }
  #carousel-banners {
    background: linear-gradient(45deg, purple, orange)!important;
  }
}

</style>