<template>
  <div class="modal">
    <!-- The modal dialog -->
    <div class="modal__dialog" :class="{'active' : active}">
      <div class="modal__content">
        <button class="modal__close" @click="click">
          X
        </button>
        <h3 class="modal__header">
          <slot name="modalHeader"></slot>
        </h3>
        <div class="modal__body">
          <slot name="modalBody"></slot>
        </div>
        <div class="modal__footer" >
          <slot name="modalFooter"></slot>
        </div>
      </div>  
    </div> 
      
    <!-- The overlay for the modal -->
    <div class="modal__overlay" v-on:click.self="click"></div> 
    
  </div>
</template>

<script>
import Vue from "vue";

  export default { 
    data() {
      return {
        active: false,
        
      }
    }, 
    created() { 
     
    },
    mounted() { 
     
    },
    
    methods: {
      close: function() {  
        this.active == false;
      },
      click() {
        this.active =! this.active;
      },
      
    }
  };
</script>

<style scope lang="scss">
  .modal-input {
    border: 1px solid #c7c7c7;
    background: #ffffff;
    box-shadow: none;
    color: #2b265a; 
    padding: 16px;
    outline: 0; 
    width: 100%;
    margin-bottom: 12px;
    border-radius: 2px;
    font-weight: 600;
    font-size: 12px;
    letter-spacing: 1px;
  }
  .modal-input::placeholder {
    color: #9b9b9b;  
    font-weight: 600;
    font-size: 12px; 
  }
  .modal-input:focus {
    color: #ff4116;
    background: #ffffff;
    border-color: #ff4116;
  }

  .modal-textarea {
    border: 1px solid #c7c7c7;
    background: #ffffff;
    box-shadow: none;
    color: #2b265a;  
    padding: 16px;
    outline: 0; 


    width: 100%;
    min-height: 150px; 
    margin-bottom: 12px; 
    border-radius: 2px;
    font-weight: 600;
    font-size: 12px;
    letter-spacing: 1px;
  }
   .modal-textarea::placeholder { 
    color: #9b9b9b; 
    font-weight: 600;
    font-size: 12px;  
  }
   .modal-textarea:focus {
    color: #ff4116;
    background: #ffffff;
    border-color: #ff4116;
  }
  
  
  
  .modal {
    display: flex;
    position: fixed; 
    z-index: 1000;
  }
  .modal__cta {
    margin: 24px 0;
    font-size: 24px;
    color: rgba(0, 0, 0, 0.45);
  }
  .modal__overlay {
    position: fixed;
    width: 100%;
    height: 100%;
    visibility: hidden;
    top: 0;
    left: 0;
    z-index: 1000;
    opacity: 0;
    background: #000000;
    transition: all 0.25s;
  }
  .modal__dialog {
    position: fixed;
    top: 50%;
    left: 50%;
    width: 50%;
    max-width: 630px;

    min-width: 320px;
    height: auto;
    z-index: 2000;
    visibility: hidden;
    backface-visibility: hidden;
    transform: translateX(-50%) translateY(-50%);
    perspective: 1300px;
  }
  .modal__dialog.active {
    opacity: 1;
    visibility: visible;
  }
  .modal__dialog.active ~ .modal__overlay {
    opacity: 0.9;
    visibility: visible;
  }
  .modal__dialog.active .modal__content {
    transform: rotateX(0deg);
    opacity: 1;
  }
  .modal__content {
    background: #fff;
    border-radius: 2px;
    color: #131313; 
    position: relative;
    transform-style: preserve-3d;
    transform: rotateX(-60deg);
    transform-origin: 50% 0;
    opacity: 0;
    transition: all 0.25s;
  }
  .modal__close {
    position: absolute;
    right: -16px;
    top: -16px;
    color: #fff;
    background: #ff4116;
    border: 0;
    outline: 0;
    border-radius: 50%;
    font-size: 16px;
    width: 32px;
    height: 32px;
    cursor: pointer;
  }
  .modal__header {
    text-align: center;
    padding-top: 24px;
    font-weight: 300;
    font-size: 24px;
    color: rgba(0, 0, 0, 0.45);
  }
 
  .modal__body {
    color: #000;
    display: flex;
    margin: 0 auto;
    padding: 0 24px;
    width: 100%;
    max-width: 400px;
    align-items: center;
    flex-direction: column;

    form {
        width: 100%;
    }
   

    h1 {
        font-size: 24px;
        color: #4a4a4a;
        width: 100%;
        text-align: center;
        margin: 0;
    }
    p {
        font-size: 14px;  
        color: #4a4a4a;
        width: 100%;
        text-align: center;
    }
    #results {
        
        font-size: 20px;  
        color: #10459e;
        margin-bottom: 12px;
    }
    .div_footer {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .button { 
        color: #fff;
        border: 0;
        font-weight: 400;
        font-size: 13px;
        height: 50px;
        text-transform: uppercase; 
        cursor: pointer;
        margin-top: 14px;
        max-width: 300px;
        display: table;
        text-align: center;
        line-height: 50px;
        padding: 0px 30px;
        background: #ff4116;
        transition: all 0.3s ease;
    
        &:hover {
            color: #fff;
            background: #ff4116;
        }
        &:active,&:focus {
            color: #fff;
            background: #ff4116;
        }
    }
  }
  .modal__footer {
    display: flex;
    margin: 0 auto;
    padding: 0 24px;
    
    width: 100%;
    max-width: 400px;
    justify-content: flex-end;
    flex-direction: row;
  }
 
  .div_footer {
    margin-bottom: 32px;
  }

</style>
