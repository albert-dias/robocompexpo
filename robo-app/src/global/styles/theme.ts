import { DefaultTheme } from "react-native-paper";

export default {
    colors: {
        background: '#40423A',
        black: '#000000',
        card: '#03646E80',
        contrast: '#006EB0',
        contrast2: '#01913E',
        contrast5: '#D8DF00',
        darkGray: '#9B9B9B',
        disabledOrange: '#E08379',
        dirtywhite: '#F6F6F6',
        google: '#FF3333',
        gradient:['#282D41','#03A4A9'],
        gradientInvert:['#03A4A9','#282D41'],
        gray: '#F4F1F0',
        green: '#83A84A',
        halfyellow:'#7D7D0080',
        middlecolor: '#248898',
        newcolor: '#282D41',
        orange: '#FF5947',
        red: '#FF0000',
        red2: '#CC0000',
        slider: '#03A4A9',
        star: '#FFD700',
        submit: '#529169',
        surface: '#31332B',
        textOnSurface: '#FFF',
        white: '#FFFAF7',
        whitepure: '#FFFFFF',
        green2: '#00aa00',
    }, 
    fonts: {
        thin:       'Manjari-100Thin',
        regular:    'Manjari_400Regular',
        bold:       'Manjari_700Bold',
    },
    PaperTheme: {
        ...DefaultTheme,
        colors: {
            ...DefaultTheme.colors,
            primary: '#000000',
            text: '#000000',
            placeholder: '#000000',
            backdrop: '#000000',
        }
    }
};