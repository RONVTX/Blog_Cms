// Replace Font Awesome <i class="fa-..."> placeholders with inline SVG <svg><use/></svg>
(function(){
    function replaceIcons(root){
        root = root || document;
        const nodes = root.querySelectorAll('i[class*="fa-"]');
        nodes.forEach(function(i){
            const classes = Array.from(i.classList);
            // find class starting with fa- but not fa/fas/far
            const faCls = classes.find(c => c.startsWith('fa-') && c !== 'fa' && c !== 'fas' && c !== 'far');
            if(!faCls) return;
            const name = faCls.replace('fa-','');
            const svg = document.createElementNS('http://www.w3.org/2000/svg','svg');
            svg.setAttribute('class','icon');
            // Preserve non-FA classes from the <i> (e.g., custom helpers) and add contextual size classes
            const keepClasses = classes.filter(c => !c.startsWith('fa') && c !== 'fa' && c !== 'fas' && c !== 'far');
            keepClasses.forEach(c => svg.classList.add(c));
            // Add contextual classes based on ancestor elements for uniform sizing
            try {
                const btnAncestor = i.closest('.btn, button, .action-btn, .admin-nav-item');
                const headerAncestor = i.closest('.navbar, .admin-topbar, .admin-logo');
                const textAncestor = i.closest('.post-stat, .post-meta, .post-footer, .post-excerpt, .post-author');
                if (btnAncestor) svg.classList.add('icon-btn');
                if (headerAncestor) svg.classList.add('icon-header');
                if (textAncestor) svg.classList.add('icon-text');
            } catch (e) {
                // ignore if closest isn't supported
            }
            svg.setAttribute('aria-hidden','true');
            svg.setAttribute('focusable','false');
            svg.setAttribute('role','img');
            // create <use>
            const use = document.createElementNS('http://www.w3.org/2000/svg','use');
            // set both href and xlink:href for compatibility
            use.setAttributeNS('http://www.w3.org/1999/xlink','xlink:href','/assets/icons.svg#' + name);
            use.setAttribute('href','/assets/icons.svg#' + name);
            svg.appendChild(use);
            // copy title or aria-label if present
            if(i.getAttribute('aria-label')) svg.setAttribute('aria-label', i.getAttribute('aria-label'));
            if(i.getAttribute('title')) svg.setAttribute('title', i.getAttribute('title'));
            i.parentNode.replaceChild(svg, i);
        });
    }

    // initial replace on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function(){
        replaceIcons(document);

        // MutationObserver to replace any future icons inserted dynamically
        const mo = new MutationObserver(function(mutations){
            mutations.forEach(function(m){
                if(m.addedNodes && m.addedNodes.length){
                    m.addedNodes.forEach(function(node){
                        if(node.nodeType === 1){
                            // if the added node itself is an <i> with fa- class
                            if(node.tagName.toLowerCase() === 'i' && node.className && node.className.indexOf('fa-') !== -1){
                                replaceIcons(node.parentNode || document);
                            } else {
                                // check inside it
                                replaceIcons(node);
                            }
                        }
                    });
                }
            });
        });

        mo.observe(document.body, { childList: true, subtree: true });

        // expose function for manual calls
        window.replaceIcons = replaceIcons;
    });
})();
