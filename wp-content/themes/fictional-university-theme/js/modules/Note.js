import  $ from 'jquery';

class MyNotes{

    //constructor goes here.
    constructor(){
        this.events();
    }

    events(){
        $("#mynotes").on("click",".edit-note", this.editNotes.bind(this));
        $("#mynotes").on("click",".delete-note",this.deleteNotes.bind(this));
        $("#mynotes").on("click",".update-note",this.updateNote.bind(this));
        $(".submit-note").on("click",this.createNote.bind(this));
    }

    //Methods will go here.
    editNotes(e){
       var dt=$(e.target).parents("li");
       
       if(dt.data("state")=="editable"){
        this.makeNoteReadable(dt);
       }else{
           this.makeNoteEditable(dt);
       }
    }



    makeNoteEditable(dt){
        dt.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i>Cancel');
        dt.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        dt.find(".update-note").addClass("update-note--visible");
        dt.data("state","editable");
    }

    makeNoteReadable(dt){
       dt.find(".edit-note").html('<i class="fa fa-edit" aria-hidden="true"></i>Edit');
       dt.find(".note-title-field, .note-body-field").attr("readonly","readonly").removeClass("note-active-field");
       dt.find(".update-note").removeClass("update-note--visible");
       dt.data("state","readable");
    }

    deleteNotes(e){
        
        var dataId=$(e.target).parents("li");

        $.ajax({ 

            beforeSend: (xhr)=>{
                xhr.setRequestHeader('X-WP-Nonce',universityData.nonce);
            },
            url: universityData.root_url+'/wp-json/wp/v2/note/'+dataId.data('id'),
            type: 'delete',
            success: (response)=>{
                dataId.slideUp();
                console.log('Congrats');
                console.log(response);

                if(response.userNoteCount<4){
                    $(".note-limit-message").removeClass("active");
                }
            },
            error: (response)=>{
                console.log('Error');
                console.log(response);
            }
        });
        
    }

    updateNote(e){
        
        var dataId=$(e.target).parents("li");

        var ourUpdatedPost={
            'title': dataId.find(".note-title-field").val(),
            'content': dataId.find(".note-body-field").val() 
        }

        $.ajax({ 

            beforeSend: (xhr)=>{
                xhr.setRequestHeader('X-WP-Nonce',universityData.nonce);
            },
            url: universityData.root_url+'/wp-json/wp/v2/note/'+dataId.data('id'),
            type: 'post',
            data: ourUpdatedPost,
            success: (response)=>{
                this.makeNoteReadable(dataId);
                console.log('Congrats');
                console.log(response);
            },
            error: (response)=>{
                console.log('Error');
                console.log(response);
            }
        });
        
    }

    createNote(e){
                
        var ourNewPost={
            'title': $(".new-note-title").val(),
            'content': $(".new-note-body").val(),
            'status': 'publish'
        }

        $.ajax({ 

            beforeSend: (xhr)=>{
                xhr.setRequestHeader('X-WP-Nonce',universityData.nonce);
            },
            url: universityData.root_url+'/wp-json/wp/v2/note',
            type: 'post',
            data: ourNewPost,
            success: (response)=>{
                $(".new-note-title, .new-note-body").val('');
                $(`
                <li data-id="${response.id}">
                            <input readonly class="note-title-field" value="${response.title.raw}">
                            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</span>
                            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</span>
                            <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
                        </li>                
                `).prependTo("#mynotes").hide().slideDown();

                console.log('Congrats');
                console.log(response);

                
            },
            error: (response)=>{
                if(response.responseText == "You have reached your note limit."){
                    
                    $(".note-limit-message").addClass("active");
                }

                console.log('Error');
                console.log(response);                
            }
        });
        
    }
}

export default MyNotes;