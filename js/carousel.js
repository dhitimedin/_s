/**
 * File carousel.js.
 *
 * Handles coverflow carousel
 */

/*Element.prototype.hasClass = function(className) {
    return this.className && new RegExp("(^|\\s)" + className + "(\\s|$)").test(this.className);
};*/

function CoverFlowCarousel(container = null) {

    this.carouselContainer = container;
    this.carouselItemContainer;
    this.carouselArray = [];
    this.carouselControls = [];
    this.coverFlowItemList = []
    let carouselContainerChildNodes = null;
    if(this.carouselContainer){
        carouselContainerChildNodes = Array.prototype.filter.call( this.carouselContainer.childNodes, function(element) { 
             return element.nodeType == 1;
         } );
    }
    
    this.autoPlay = true;
    
    if( carouselContainerChildNodes ) {
        carouselContainerChildNodes.forEach( ( node, index) => {
            if( node.className.match( /spi-coverflow-wrapper+/ ) )
            {
                this.carouselItemContainer = node;

                    if(this.carouselItemContainer.hasAttribute("data-autoplay"))
                    {
                        this.autoPlay = (this.carouselItemContainer.getAttribute("data-autoplay") == "true") ? true: false;
                    }
                
                var gContainerChildNodes = node.childNodes;
                gContainerChildNodes = Array.prototype.filter.call(gContainerChildNodes, function(element) { 
                     return element.nodeType == 1;
                 });            
                gContainerChildNodes.forEach((e,i) =>{
                    if(e.className.match(/coverflow-item+/)){
                        this.carouselArray.push(e);
                        //console.log(e.className.match(/coverflow-helper-(.*)/));
                        if(e.className.match(/coverflow-helper-(.*)/)){
                            this.coverFlowItemList.push((e.className.match(/coverflow-helper-(.*)/))[0]);
                        }                        
                    }
                });
            }
            else if( ( node.className.match( /icon-(\w+)-coverflow/i ) ) )
            {
                this.carouselControls.push( node );
            }
            else if( (node.className.match(/icons-(.*)/)) )
            {
                this.carouselControls = Array.prototype.filter.call(node.childNodes, function(element) { 
                     return element.nodeType == 1;
                 });
            }            

        });
    }
    let width = parseInt((window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth), 10);
    if((width < 768) && (this.coverFlowItemList[0].match(/coverflow-helper-(.*)2$/)) && (this.carouselArray.length > 1))
    {
        this.autoPlay = true;
    }
    this.myInter = setInterval(() => {}, 7000);


    // Update css classes for gallery
    this.updateGallery = function () {
    this.carouselArray.forEach(el => {
        if((/coverflow-helper-(.*)/).test(el.className))    
        {

            /* Removed all the helper classes that provides animation affect e.g.
             * el.classList.remove('coverflow-item-1', 'coverflow-item-2', 
             * 'coverflow-item-3', 'coverflow-item-4', 'coverflow-item-5');
             */
            el.classList.remove(...this.coverFlowItemList);
            
        }
            
    });

        this.carouselArray.forEach((el, i) => {
            //adds the helper classes back to the new list in the order they appear
          el.classList.add(this.coverFlowItemList[i]);
        });
    };

    // Update the current order of the carouselArray and gallery
    this.setCurrentState = function (direction = null) {
        clearInterval(this.myInter);
        if ((direction != null) && direction.className.match(/icon-right-coverflow(.*)/)) {
          this.carouselArray.unshift(this.carouselArray.pop());
        } else {
          this.carouselArray.push(this.carouselArray.shift());
        }

        this.updateGallery();

        //Continuing the movement after stop
        this.myInter = this.autoPlay ? 
            setInterval(() => {this.setCurrentState();}, 7000): setInterval(() => {}, 7000);  
    }

    // Add a click event listener to trigger setCurrentState method to rearrange carousel
    this.useControls = function () {

        //Setting a repeated movement
        clearInterval(this.myInter);

        this.carouselControls.forEach(control => {
          control.addEventListener('click', e => {
            e.preventDefault();

            //clear the previous rotation movement
            this.setCurrentState(control);
          });
        });

        //Stop slider when the window is invisible
        if((this.autoPlay))
        {
            
            let hidden, visibilityChange;
            if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support
                hidden = "hidden";
                visibilityChange = "visibilitychange";
            } else if (typeof document.msHidden !== "undefined") {
                hidden = "msHidden";
                visibilityChange = "msvisibilitychange";
            } else if (typeof document.webkitHidden !== "undefined") {
                hidden = "webkitHidden";
                visibilityChange = "webkitvisibilitychange";
            }

            // Warn if the browser doesn't support addEventListener or the Page Visibility API
            if (typeof document.addEventListener === "undefined" || hidden === undefined) {
              //console.log("Automated This demo requires a browser, such as Google Chrome or Firefox, that supports the Page Visibility API.");
            } else {
              // Handle page visibility change

                document.addEventListener("visibilitychange", () => {
                    if (document[hidden]) {
                        clearInterval(this.myInter);
                        this.myInter = setInterval(() => {}, 7000);
                        this.autoPlay = false;
                    } else {
                        clearInterval(this.myInter);
                        this.myInter = setInterval(() => {this.setCurrentState();}, 7000);
                        this.autoPlay = true;
                    }
                });

            }            

        }
        
        //Set up for partner carousel. It helps set automatic carousel on window resize. 
        window.addEventListener('resize', () => {

            let width = parseInt((window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth), 10);
            if((width < 768) && (this.coverFlowItemList[0].match(/coverflow-helper-(.*)2$/)) && (this.carouselArray.length > 1))
            {
                clearInterval(this.myInter);
                this.autoPlay = true;
                this.myInter = setInterval(() => {this.setCurrentState();}, 7000);
            }
            
            if((this.coverFlowItemList[0].match(/coverflow-helper-(.*)2$/))&& (width > 768))
            {
                clearInterval(this.myInter);
                this.autoPlay = false;
            }
        });
                
        this.myInter = this.autoPlay ? 
            setInterval(() => {this.setCurrentState();}, 7000): setInterval(() => {}, 7000);   

      }
}   

const coverFlowList = document.querySelectorAll('[class*="spi-coverflow-container"]');
if(coverFlowList.length>=1)
{
    coverFlowList.forEach((e, i) => {
        let exampleCarousel = new CoverFlowCarousel(e);
        exampleCarousel.useControls();        
    });

}



/**
 * For the Vertical Carousel
 * @type {Element}
 */

class HomeCarousel {

    /**
     * 
     * @param {type HTMLDOMElement} containervert
     * @param {type HTMLDOMElement} containerhztl
     * @param {type HTMLDOMElement} captionContainer
     * @param {type HTMLDOMElement} dotContainerNode
     * @return {HomeCarousel}
     */
    constructor(containervert=null, containerhztl=null, captionContainer=null, dotContainerNode) {
        this.carouselContainerVert = containervert;
        this.captionContainer = captionContainer;
        this.dotContainerNode = dotContainerNode; 
        this.carouselContainerHztl = containerhztl;            
        this.carouselArrayVert = [];
        this.carouselArrayHztl = [];            
        this.triggers = [];
        this.captionItems = [];
        this.dotChildNode = [];            
        this.flag = [false, false];
        this.autoPlay = true;

        if(this.carouselContainerHztl){
            this.carouselArrayHztl = Array.prototype.filter.call(this.carouselContainerHztl.childNodes, function(element) { 
                         return element.nodeType == 1;
                     });
        }

        this.logArray = [...Array(this.carouselArrayHztl.length).keys() ]
        this.numSliders = this.carouselArrayHztl.length;

        if(this.dotContainerNode){
            this.dotChildNode = Array.prototype.filter.call(dotContainerNode.childNodes, function(element) { 
                             return element.nodeType == 1;
                         });                
        }


        if(this.carouselContainerVert) {
            let childNodesArray =   this.carouselContainerVert.childNodes;
            childNodesArray.forEach ((el) => {
                if(el.nodeType ==1) {
                    if(el.classList.contains('animatebox')) {
                        this.carouselArrayVert.push(el);
                    } 
                    //String matching with icon- followed by string starting with t(op), l(eft), b(ottom),r(ight)
                    else if(el.className.match(/icon-[tlbr](.*)/)) { 
                        this.triggers.push(el);
                    }
                }
            });    
        }
        
        if(this.carouselArrayVert.length > 0){ 
            this.flag[0] = true;
        }          

        if(this.captionContainer){
            this.captionItems = Array.prototype.filter.call(this.captionContainer.childNodes, function(element) { 
                         return element.nodeType == 1;
                     });                
        }      
        
        if(this.captionItems.length > 0){ 
            this.flag[1] = true;
        }
        
        this.homeSlideInter = setInterval(() => {}, 7000); 
    }


    /**
     * Update css classes for gallery
     * @return {undefined}
     */
    updateGallery() {
        // Check if the vertical carousel exists
        if(this.flag[0]){
            this.carouselArrayVert.forEach(el => {
                if(el.classList.contains('animatebox-5') || el.classList.contains('animatebox-2')){
                    el.onclick = null; 
                }
                el.classList.remove('animatebox-1', 'animatebox-2', 'animatebox-3', 
                    'animatebox-4', 'animatebox-5', 'animate-other');
            });
        }

        //check if caption block exists
        if(this.flag[1]){
        this.captionItems.forEach(el => {
            el.style.left = "100%";
            if(el.classList.contains('caption-active')){
                el.classList.remove('caption-active');
            }
        }); 
        this.captionItems[0].classList.add('caption-active');
        this.captionItems[0].style.left = "0";
        }

        this.carouselArrayHztl.forEach(el => {
            el.classList.remove('active-1', 'active-2', 'active-3', 
                'active-4', 'active-5', 'active-other');
        }); 

        //update vertical carousel and activate triggers for item clicking
        if(this.flag[0]) {
        this.carouselArrayVert.slice(0, 3).forEach((el, i) => {
          el.classList.add(`animatebox-${i+1}`);
          //next element
            if((i+1) == 2) {

                el.onclick =  e => {
                        e.preventDefault();

                        //clear the previous rotation movement
                        clearInterval(this.homeSlideInter);
                        this.setCurrentState(el);
                        e.target.onclick = null;
                };                      
            }            
        });            

        this.carouselArrayVert.slice(this.numSliders - 2, this.numSliders).forEach((el, i) => {
          el.classList.add(`animatebox-${i+4}`);
            // previous elment 
            if((i+4) == 5) { 
               el.onclick =  e => {
                        e.preventDefault();

                        //clear the previous rotation movement
                        clearInterval(this.homeSlideInter);
                        this.setCurrentState(el);
                        e.target.onclick = null;
                    };               
            }            
        });        
        }


        //arrainge the active element and subsequent two elements
        this.carouselArrayHztl.slice(0, 3).forEach((el, i) => {
        el.classList.add(`active-${i+1}`);
        });
        
        //arrainge the last two elements before the active element
        this.carouselArrayHztl.slice(this.numSliders - 2, this.numSliders).forEach((el, i) => {
        el.classList.add(`active-${i+4}`);
        });         

        if(this.numSliders > 5) {
            for(var i=3; i < (this.numSliders - 2); i++){
                this.carouselArrayHztl[i].classList.add('active-other');
                if(this.flag[0]){
                    this.carouselArrayVert[i].classList.add('animate-other');
                }
            }
        }

    }


    /**
    * Update the current order of the carouselArray and gallery
    * @param {type DOMElement} direction
    * @return {undefined}
    */
    setCurrentState(direction = null) {

        // clear timer
        clearInterval(this.homeSlideInter);

        //for Dot indicators clear the active element before the carousel movement
        this.dotChildNode[this.logArray[0]].className = 'dot';
        //check if things has been triggered by item clicking, cantrols, 
        // or a timmer triggered movement
        if(direction){ //contains('icon-bottom') || direction.classList.contains('icon-right')
                if (direction.className.match(/icon-[br](.*)/) || direction.classList.contains('animatebox-5')) {
                if(this.flag[0]) {
                    this.carouselArrayVert.unshift(this.carouselArrayVert.pop());                
                }            

                if(this.flag[1]) {
                    this.captionItems.unshift(this.captionItems.pop());                
                }                 

                this.carouselArrayHztl.unshift(this.carouselArrayHztl.pop());
                this.logArray.unshift(this.logArray.pop());
            } else {
                if(this.flag[0]) {            
                    this.carouselArrayVert.push(this.carouselArrayVert.shift());
                }

                if(this.flag[1]) {            
                    this.captionItems.push(this.captionItems.shift());
                }

                this.carouselArrayHztl.push(this.carouselArrayHztl.shift()); 
                this.logArray.push(this.logArray.shift());
            }
        }
        else
        {
            //Execute if it is timmer triggered
            //check flag for presence of captions
            if(this.flag[1]) {            
                this.captionItems.push(this.captionItems.shift());
            }
            if(this.flag[0]) {            
                this.carouselArrayVert.push(this.carouselArrayVert.shift());
            }                    
            this.carouselArrayHztl.push(this.carouselArrayHztl.shift()); 
            this.logArray.push(this.logArray.shift());

        }

        this.updateGallery();
        this.dotChildNode[this.logArray[0]].className = 'dot hmecrslatve';

        //Continuing the movement after stop
        this.homeSlideInter = this.autoPlay ? 
            setInterval(() => {this.setCurrentState();}, 7000): setInterval(() => {}, 7000);
    }
    
    
        /**
    * Update the current order of the carouselArray and gallery
    * @param {type DOMElement} direction
    * @return {undefined}
    */
    setCurrentStateFlag(flag=0, counter, gap) {
        //for Dot indicators clear the active element before the carousel movement
        this.dotChildNode[this.logArray[0]].className = 'dot';
        //check if things has been triggered by item clicking, cantrols, 
        // or a timmer triggered movement
        if(flag){ //contains('icon-bottom') || direction.classList.contains('icon-right')
            if(this.flag[0]) {
                this.carouselArrayVert.unshift(this.carouselArrayVert.pop());                
            }            

            if(this.flag[1]) {
                this.captionItems.unshift(this.captionItems.pop());                
            }                 

            this.carouselArrayHztl.unshift(this.carouselArrayHztl.pop());
            this.logArray.unshift(this.logArray.pop());
       } 
       else 
       {
            if(this.flag[0]) {            
                this.carouselArrayVert.push(this.carouselArrayVert.shift());
            }

            if(this.flag[1]) {            
                this.captionItems.push(this.captionItems.shift());
            }

            this.carouselArrayHztl.push(this.carouselArrayHztl.shift()); 
            this.logArray.push(this.logArray.shift());
        }

        this.updateGallery();
        counter++;
        if(counter >= gap){
            clearInterval(this.homeSlideInter);
            this.dotChildNode[this.logArray[0]].className = 'dot hmecrslatve';
            this.carouselArrayHztl.forEach((e)=>{
                    e.style.transition = "all 2s ease";
                });

           //Continuing the movement after stop
        this.homeSlideInter = this.autoPlay ? 
            setInterval(() => {this.setCurrentState();}, 7000): setInterval(() => {}, 7000);          
            
        }

    }
    
    

    /*
     * Move slides based on the selection
     * @param selected is id of the clicked dot element  
     */
    moveState(selected) {
        //clears the timmer
        clearInterval(this.homeSlideInter);

        //deselects the active dot element
        this.dotChildNode[this.logArray[0]].className = 'dot';

        //checks if the selection is right or left of the active element
        if(selected > this.logArray[0]) {
            let gap = this.logArray.indexOf(selected);
            //for(var i=0; i < gap; i++){
                this.carouselArrayHztl.forEach((e)=>{
                    e.style.transition = "all 0.5s linear";
                });
                let counter = 0;
                this.homeSlideInter = setInterval(() => { 
                    if(counter < gap){
                        this.setCurrentStateFlag(0, counter, gap);
                    }
                    counter++;
                }, 500);
                
        }
        else
        {
            let gap = this.logArray.length - this.logArray.indexOf(selected);            
            //for(var i=0; i < gap; i++){
                this.carouselArrayHztl.forEach((e)=>{
                    e.style.transition = "all 0.5s linear";
                });            
                let counter = 0;
                this.homeSlideInter = setInterval(() => { 
                    if(counter < gap){
                        this.setCurrentStateFlag(1, counter,gap);
                    }
                    counter++;
                }, 500);
 
        } 
    }      


    /**
     * Convert dimention in pixels to Vieport Width
     * @param {type} entered px value
     * @return {Number} converted value
     */
    pxTOvw(value) {
        let w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        x = w.innerWidth || e.clientWidth || g.clientWidth,
        y = w.innerHeight|| e.clientHeight|| g.clientHeight;

        var result = (100*value)/x;
        //  document.getElementById("result_px_vw").innerHTML = result;  // affichage du résultat (facultatif)
        return ((100*value)/x);
    } 


    /**
     * Add a click event listener to trigger setCurrentState method to rearrange carousel
     * @return {undefined}
     */
    useControls() {

        //clears the timer
        clearInterval(this.homeSlideInter);

        //calls the movement
           //Continuing the movement after stop
        this.homeSlideInter = this.autoPlay ? 
            setInterval(() => {this.setCurrentState();}, 7000): setInterval(() => {}, 7000);
        
        if((this.autoPlay))
        {
            
            let hidden, visibilityChange;
            if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support
                hidden = "hidden";
                visibilityChange = "visibilitychange";
            } else if (typeof document.msHidden !== "undefined") {
                hidden = "msHidden";
                visibilityChange = "msvisibilitychange";
            } else if (typeof document.webkitHidden !== "undefined") {
                hidden = "webkitHidden";
                visibilityChange = "webkitvisibilitychange";
            }

            // Warn if the browser doesn't support addEventListener or the Page Visibility API
            if (typeof document.addEventListener === "undefined" || hidden === undefined) {
              //console.log("Automated This demo requires a browser, such as Google Chrome or Firefox, that supports the Page Visibility API.");
            } else {
              // Handle page visibility change

                document.addEventListener("visibilitychange", () => {
                    if (document[hidden]) {
                        clearInterval(this.homeSlideInter);
                        this.homeSlideInter = setInterval(() => {}, 7000);
                        this.autoPlay = false;
                    } else {
                        clearInterval(this.homeSlideInter);
                        this.homeSlideInter = setInterval(() => {this.setCurrentState();}, 7000);
                        this.autoPlay = true;
                    }
                });

            }            

        }
        

        //activates the first and third element so user can select them
        if(this.flag[0]) {
            this.carouselArrayVert.forEach(control => {
                if((control.classList.contains('animatebox-5')) || (control.classList.contains('animatebox-2'))) {                      
                    control.onclick =  e => {
                            e.preventDefault();

                            //clear the previous rotation movement
                            clearInterval(this.homeSlideInter);
                            this.setCurrentState(control);
                            e.target.onclick = null;
                        };
                }
            });
        }

        //if the triggers are there then activate them
        if(this.triggers){
            this.triggers.forEach(control => {

              control.addEventListener('click', e => {

                e.preventDefault();

                //clear the previous rotation movement
                clearInterval(this.homeSlideInter);
                this.setCurrentState(control);

              });
            });
        }

        if(this.dotChildNode){
            this.dotChildNode.forEach((e, index) => {
                e.setAttribute('id', index);
                e.addEventListener('click', e => {
                        e.preventDefault();

                        clearInterval(this.homeSlideInter);
                        this.moveState(parseInt(e.currentTarget.id));
                      });
            });                
        }

        //Setup event handler fortoggling captions
        if(this.captionItems){
            //Storing the Accordion Elements
            this.acc = [];
            this.panel = [];
            this.maxScrlHeight = 0;  //Storing Max height of the panel elements
            
            this.captionItems.forEach((e,index) => {
                e.childNodes.forEach((element,index) => {
                            if(element.nodeType == 1){
                                if(element.classList.contains('spi-accordion-media')){
                                    this.acc.push(element);
                                }
                                else if(element.classList.contains('spi-panel-media')){
                                    this.panel.push(element);
                                    
                                    //Checking what is the max scroll(content) height of the panel element and storing that value
                                    this.maxScrlHeight = 
                                            (this.maxScrlHeight < element.scrollHeight) ? element.scrollHeight : this.maxScrlHeight;
                                }
                            }
                         });

            });

            //Checking is there are any accordion elements
            if(this.acc.length>=0){
                let par = this;
               
                //Iterating over all the accordion elements to set a click event listener
                this.acc.forEach((element,ind) => {
                    element.addEventListener("click", el => {
                        //Checking is accordion is open or closed
                        if((el.srcElement.nextElementSibling).style.maxHeight){
                            //If open then maked changes to all related elements 
                            par.captionContainer.style.height = par.pxTOvw(parseFloat(window.getComputedStyle(par.captionContainer).height) - par.maxScrlHeight) + "vw";                                        
                            par.carouselContainerHztl.parentNode.style.height = par.pxTOvw(parseFloat(window.getComputedStyle(par.carouselContainerHztl.parentNode).height) - par.maxScrlHeight) + "vw";
                            par.captionItems.forEach((elm,ind)=>{
                                elm.style.height = par.pxTOvw(parseFloat(window.getComputedStyle(elm).height) - par.maxScrlHeight) + "vw";
                                par.panel[ind].style.maxHeight = null; //close all accordion panel element
                                par.acc[ind].classList.toggle("spi-accordion-media-active");
                            });
                        }
                        else {
                            //closed then make adjustment to heights of related elements to open and display
                            par.captionContainer.style.height = par.pxTOvw(parseFloat(window.getComputedStyle(par.captionContainer).height) + par.maxScrlHeight) + "vw";
                            par.carouselContainerHztl.parentNode.style.height = par.pxTOvw(parseFloat(window.getComputedStyle(par.carouselContainerHztl.parentNode).height) + par.maxScrlHeight) + "vw";
                            par.captionItems.forEach((elm,ind)=>{
                                elm.style.height =  this.pxTOvw(parseFloat(window.getComputedStyle(elm).height) + par.maxScrlHeight) + "vw";
                                par.panel[ind].style.maxHeight = par.pxTOvw(par.maxScrlHeight) + "vw"; //Opening all accordion panel element
                                par.acc[ind].classList.toggle("spi-accordion-media-active");
                            });                                
                        }

                  });                    
                });    
            } 
        }

    }

}


const slideshowNodeList = document.querySelectorAll('[class*="spi-slider-container"]');
//console.log(slideshowNodeList);
if(slideshowNodeList.length>=0){
    
    slideshowNodeList.forEach((node,ind)=>{
        let cntnrChldrn = Array.prototype.filter.call(node.childNodes, function(element) { 
                     return element.nodeType == 1;
                 });
        let coverNode = dotContainerNode = captionContainer = slideshowNode = null;
        if(cntnrChldrn.length>=1){
            cntnrChldrn.forEach((e,i) => {
                if(e.className.match(/spi-vertical-container(.*)/)){
                    coverNode = e;
                }
                else if(e.className.match(/spi-dot-container(.*)/)){
                    dotContainerNode = e;
                }
                else if(e.className.match(/spi-caption-block(.*)/)){
                    captionContainer = e;
                }
                else if(e.className.match(/spi-slideshow-wrapper(.*)/)){
                    slideshowNode = e;
                }

            })
        }
        if(slideshowNode != null){
            let carouselInstance = new HomeCarousel(coverNode, slideshowNode, captionContainer, dotContainerNode);
            carouselInstance.useControls();
        }
    })
  
}


