import { createStateLink } from "@hookstate/core";
import { createRef } from 'react';
import { ScrollView } from "react-native";
import { RootLoggedStackParamList } from "../../pages/LoggedStackNavigator";

const scrollRef = createRef<ScrollView>();
const actualRouteRef = createStateLink<keyof RootLoggedStackParamList>('Home');

const moveToTop = () => scrollRef.current.scrollTo({
    x:0,
    y:0,
    animated: true,
});

const appbar = {
    actualRouteRef,
    moveToTop,
    scrollRef
};

export default appbar;