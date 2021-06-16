import $ from 'jquery';

class Search {

    // describe/create/initiate our object
    constructor(){
        this.addSearchHTML();
        this.searchResult=$(".search-overlay__result");
        this.openButton=$(".js-search-trigger");
        this.closeButton=$(".search-overlay__close");
        this.searchOverlay=$(".search-overlay");
        this.searchField=$("#search-term");
        this.typingTimer;
        this.isSpinnerVisible=false;
        this.previousValue;
        this.events();
    }

    //Events
    events(){
        this.openButton.on("click",this.openOverlay.bind(this));
        this.closeButton.on("click",this.closeOverlay.bind(this));
        $(document).on("keydown",this.keyPressDispatcher.bind(this));
        this.isOpenOverlayClicked=false;
        this.searchField.on("keyup",this.typingLogic.bind(this));
    }

    typingLogic(){
        
        if(this.previousValue!=this.searchField.val()){
         
            clearTimeout(this.typingTimer);
            if(this.searchField.val()){
                if(!this.isSpinnerVisible){
                    this.searchResult.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible=true;
                }
                
                this.typingTimer=setTimeout(this.getResult.bind(this),2000);
            }else{
                this.searchResult.html('');
                isSpinnerVisible=false;
            }

           
        }
        this.previousValue=this.searchField.val();
    }

    getResult(){

        $.getJSON(universityData.root_url+'/wp-json/university/v1/search?term='+this.searchField.val(), (results)=>{
            this.searchResult.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                        ${results.general_info.length ? '<ul class="link-list min-list">' : '<p>No general information found </p>'}
                        ${results.general_info.map(item=>`<li><a href="${item.permalink}">${item.title}</a>  ${item.type == 'post' ? ` by ${item.authorName}` : ''}</li>`).join('')}
                        ${results.general_info.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.program.length ? '<ul class="link-list min-list">' : `<p>No programs match that search. <a href="${universityData.root_url}/programs/"> View all programs </a></p>`}
                        ${results.program.map(item=>`<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                        ${results.program.length ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Professors</h2>
                        ${results.professor.length ? '<ul class="link-list min-list">' : `<p>No programs match that search.</p>`}
                        ${results.professor.map(item=>`
                                <li class="professor-card__list-item"><a class="professor-card" href="${item.permalink}">
                                    <img class="professor-card__image" src="${item.image}">
                                    <span class="professor-card__name">${item.title}</span>
                                    </a>
                                </li>`).join('')}
                        ${results.professor.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>
                        ${results.campus.length ? '<ul class="link-list min-list">' : `<p>No campuses match that search. <a href="${universityData.root_url}/campuses"> View all campuses </a></p>`}
                        ${results.campus.map(item=>`<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                        ${results.campus.length ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Events</h2>
                        ${results.event.length ? `` : `<p>No events match that search. <a href="${universityData.root_url}/events"> View all events </a></p>`}
                        ${results.event.map(item=>`
                            <div class="event-summary">
                                <a class="event-summary__date event-summary__date--beige t-center" href="${item.permalink}">
                                <span class="event-summary__month">${item.month}</span>
                                <span class="event-summary__day">${item.day}</span>
                                </a>
                                <div class="event-summary__content">
                                <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                                <p>${item.eventExcerpt}
                                    <a href="${item.permalink}" class="nu gray">Read more</a></p>
                                </div>
                            </div>
                        
                        `).join('')}
                    </div>
                </div>
            `);
        });
        
        this.isSpinnerVisible=false;
    }


    keyPressDispatcher(e){
        
        if(e.keyCode==83 && !this.isOpenOverlayClicked && !$("input, textarea").is(':focus')){
            this.openOverlay();
        }
        if(e.keyCode==27 && this.isOpenOverlayClicked){
            this.closeOverlay();
        }
    }
    //methods
    openOverlay(){
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        setTimeout(()=> this.searchField.trigger('focus'), 301);
        this.searchField.val('');
        
        
        this.isOpenOverlayClicked=true;
         return false;
    }

    closeOverlay(){
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOpenOverlayClicked=false;
    }

    addSearchHTML(){
        $("body").append(`
        <div class="search-overlay">
            <div class="search-overlay__top">
            <div class="container">
                <i class="fa fa-search search-overlay__icon" area-hidden="true"></i>
                <input type="text" class="search-term" placeholder="What are you looking for? " id="search-term">
                <i class="fa fa-window-close search-overlay__close" area-hidden="true"></i>
            </div>
            </div>
            <div class="container">
            <div class="search-overlay__result">
            </div>
            </div>
        </div>`);
    }
}

export default Search;