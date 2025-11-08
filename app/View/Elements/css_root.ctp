    <style>
      :root {
        --box-shadow: rgba(0, 0, 0, 0.2) 0 0 6px;
        --box-dropshadow: 0 -2px 5px rgba(0, 0, 0, 0.15);
        --box-shadow-inset: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        --box-shadow-downwards: rgba(0, 0, 0, 0.025) 0px 4px 8px -1px, rgba(0, 0, 0, 0.025) 0px 2px 3px -1px;
        --google-fonts-name: <?=@$data['google_font_name'] ?>;
      }

      html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video { 
        margin: 0; 
        padding: 0; 
        border: 0;  
        font-size: 100%; 
        vertical-align: baseline; 
      }

      html, body { 
        font-family: '<?=@$data['google_font_name'] ?>', Verdana, Arial, Sans-Serif!important;
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

      caption, th, td { text-align: left; font-weight: normal; vertical-align: middle; }

      q, blockquote { quotes: none; }
      q:before, q:after, blockquote:before, blockquote:after { content: ""; content: none; }

      a img { border: none; }

      article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary { display: block; }

      * { outline: none; }

      a, a:hover, a:active, a:focus, a:visited { cursor: pointer; text-decoration: none!important; }

      /* responsiveness */

      .mobile, .desktop {
        display: none;
      }

      @media screen and (max-width:768px), print {
        .mobile {
          display: block;
        }
        .desktop {
          display: none;
        }
      }

      @media screen and (min-width:769px), print {
        .mobile {
          display: none!important;
        }
        .desktop {
          display: block;
        }        
      }
    </style>