/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

function useCheckIfBanned(state, bannedStates) {
  const result = bannedStates
    .split(",")
    .filter((s) => s.trim().toLowerCase() === state.title.trim().toLowerCase());

  return result.length > 0 ? true : false;
}

function is5digits(input) {
  return input.match(/^[/\d]{5}?$/) !== null;
}

const { state, actions, callbacks } = store("service-area", {
  state: {
    get hasResult() {
      const context = getContext();
      return (
        (context.zipfound || context.zipinvalid || context.zipbanned) ?? false
      );
    },
    urlZipcode: "",
    getUrlParamZipcode: () => {
      const urlParams = new URLSearchParams(window.location.search);
      state.urlZipcode = urlParams.get("zipcode");
    }
  },
  actions: {
    *submit() {
      const context = getContext();

      const result = callbacks.checkIfZipcodeExist();
      console.log(result);
      if (result.length > 0) {
        const isBanned = useCheckIfBanned(
          result[0],
          state.attributes.bannedStates
        );
        if (isBanned) {
          context.zipfound = null;
          context.zipinvalid = null;
          context.zipbanned = true;
        } else {
          context.zipfound = true;
          context.zipinvalid = null;
          context.zipbanned = null;
        }
      } else {
        context.zipfound = null;
        context.zipinvalid = true;
        context.zipbanned = null;
      }
      context.showMessages = true;

      const { actions } = yield import("@wordpress/interactivity-router");
      yield actions.navigate(`${state.current_url}?zipcode=${context.zipcode}`);
      // console.log(`${state.currentv_url}?zip=${zipcode}`);
      // console.log(state.url);

      // var url = new URL(state.current_url);
      // url.searchParams.set("zipcode", context.zipcode);
      // console.log(url);

      state.getUrlParamZipcode();
    },
    *goBack() {
      const context = getContext();
      const { actions } = yield import("@wordpress/interactivity-router");
      yield actions.navigate(`${state.current_url}`);
      context.zipfound = null;
      context.zipinvalid = null;
      context.zipbanned = null;
      context.zipcode = null;
    },
    clear: () => {
      const context = getContext();
      context.showMessages = false;
      actions.goBack();
    }
  },
  callbacks: {
    setZipcode: () => {
      const context = getContext();
      const { ref } = getElement();
      context.zipcode = ref.value;
    },
    setGoogleMap: () => {
      const context = getContext();
      const { zipcode } = context;
      const { ref } = getElement();
      const iframe = ref.getElementsByTagName("iframe")[0];

      const result = callbacks.checkIfZipcodeExist();

      if (result.length > 0 && iframe) {
        const src = iframe.getAttribute("src");
        var href = new URL(src);
        href.searchParams.set(
          "q",
          `${result[0].title} ${result[0].code} ${zipcode} USA`
        );
        iframe.setAttribute("src", href);
      }
    },
    checkIfZipcodeExist: () => {
      const context = getContext();
      return state.state_zipcodes.filter(
        (zip) =>
          parseInt(context.zipcode) >= parseInt(zip.min) &&
          parseInt(context.zipcode) <= parseInt(zip.max)
      );
    },
    onLoad: () => {
      const context = getContext();

      if (context.zipcode > 0) actions.submit();
    }
  }
});
