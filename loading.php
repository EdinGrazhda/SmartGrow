
<div id="loading-screen">
    <div class="spinner"></div>
</div>

<style>

    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #308a56;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }


    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid rgba(255, 255, 255, 0.3); 
        border-top: 5px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite; 
    }

    /* Animacioni për spinner */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

  
    body.loading #loading-screen {
        display: flex;
    }

    body:not(.loading) #loading-screen {
        display: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
       
        setTimeout(function () {
            document.body.classList.remove('loading');
        }, 1200);
    });
</script>
