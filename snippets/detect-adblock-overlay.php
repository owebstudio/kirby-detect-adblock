<style>
    #detectAdBlockOverlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.75);
        z-index: 2;
        cursor: pointer;
    }

    #detectAdBlockInfo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        color: black;
        background: white;
        padding: 3rem;
        border-radius: .25rem;
        text-align: center;
    }

    #detectAdBlockInfo h3 {
        font-size: 2em;
    }

    #detectAdBlockInfo button {
        margin-top: 1rem;
        background-color: #333;
        border: none;
        color: white;
        padding: .5rem 1rem;
        text-align: center;
        text-decoration: none;
        border-radius: .25rem;
    }
</style>

<div id="detectAdBlockOverlay">
    <div id="detectAdBlockInfo">
        <h3><?= esc(option('owebstudio.detect-adblock.title')) ?></h3>
        <p><?= esc(option('owebstudio.detect-adblock.text')) ?></p>
        <button type="button" onclick="location.reload();"><?= esc(option('owebstudio.detect-adblock.button')) ?></button>
    </div>
</div>
