import { ADD_MUSIC, SET_WIDTH, SET_EXPAND } from './mutation-names';

export default {
    [SET_WIDTH](state, width) {
        state.windowWidth = width;
    },

    [SET_EXPAND](state, expand) {
        state.expand = expand;
    },
}
