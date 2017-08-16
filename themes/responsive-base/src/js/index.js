import { setupHeader } from "./header";
import { fixToggleFlyoutBehaviour } from "./overrides";

$(() => {
    setupHeader();

    fixToggleFlyoutBehaviour();

    $("select").wrap('<div class="SelectWrapper"></div>');
});
