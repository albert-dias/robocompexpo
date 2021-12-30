import { TransitionPresets } from "@react-navigation/stack";
import theme from "../global/styles/theme";

const screenOptions = {
    ...TransitionPresets.SlideFromRightIOS,
    cardStyle: {
        backgroundColor: theme.colors.background,
    },
    headerShown: false,
};

export default screenOptions;