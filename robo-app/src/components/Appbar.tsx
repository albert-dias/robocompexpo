// Import de pacotes
import React, { memo, useEffect, useState } from 'react';
import { Keyboard, StyleSheet, View } from 'react-native';
import { IconButton, Text, TouchableRipple } from 'react-native-paper';
import styled from 'styled-components/native';
import { animated } from 'react-spring';
import { useIsFocused, useNavigation, useNavigationState } from '@react-navigation/native';
import { useStateLink, useStateLinkUnmounted } from '@hookstate/core';
import { StackNavigationProp } from '@react-navigation/stack';

// Import de páginas
import theme from '../global/styles/theme';
import GlobalContext from '../context';
import { BottomNav, IconWrapper, StyledIconButton, StyledText } from './GlobalCSS';
import { FCWithLoggedStackNavigator, RootLoggedStackParamList } from '../pages/LoggedStackNavigator';

// Import de imagens
import UserProfile from '../../assets/images/avatar.png';

interface AppbarProps {
    children: React.ReactNode;
}

const {
    appbar: { scrollRef, actualRouteRef },
} = GlobalContext;

const Appbar: React.FC<AppbarProps> = ({ children }) => {
    const [hide, setHide] = useState(false);
    const actualRoute = useStateLink(actualRouteRef);
    const [showSidebar, setShowSidebar] = useState(false);
    const AnimatedBottomNav = animated(BottomNav);

    const toggle = () => {
        setHide(p => !p);
    };

    useEffect(() => {
        Keyboard.addListener('keyboardDidShow', toggle);

        Keyboard.addListener('keyboardDidHide', toggle);
    }, []);

    return (
        <View style={{ flexGrow: 1 }}>
            {children}
            <AnimatedBottomNav
                style={{
                    height: hide ? 0 : 70,
                    backgroundColor: 'rgba(249, 249, 249, 0.3)',
                }}>
                <TouchableRipple style={{ flexGrow: 1 }}
                    onPress={() => { console.log('navigate(Home);') }}>
                    <IconWrapper active={actualRoute.value === 'Home'}>
                        <StyledIconButton
                            active={actualRoute.value === 'Home'}
                            icon="home"
                            size={26}
                        />
                        <StyledText
                            style={{
                                margin: 'auto',
                                color: theme.colors.black,
                                elevation: 20,
                            }}>
                            Início
                        </StyledText>
                    </IconWrapper>
                </TouchableRipple>

                <TouchableRipple style={{ flexGrow: 1 }}
                    onPress={() => {
                        setShowSidebar(false);
                        console.log('navigate(InOrder);')
                    }}>
                    {/* Alterar os 3 'InOrder' por 'Informations' */}
                    <IconWrapper active={actualRoute.value === 'InOrder'}>
                        <StyledIconButton
                            active={actualRoute.value === 'InOrder'}
                            icon="information"
                            size={26}
                        />
                        <StyledText
                            style={{
                                margin: 'auto',
                                color: theme.colors.black,
                                elevation: 20,
                            }}>
                            Informações
                        </StyledText>
                    </IconWrapper>
                </TouchableRipple>
            </AnimatedBottomNav>
        </View>
    );
}

export const withAppbar: <T extends keyof RootLoggedStackParamList>(
    Component: FCWithLoggedStackNavigator<T>,
) => FCWithLoggedStackNavigator<T> = Component => props => {
    const {routes, index} = useNavigationState(s => s);
    const isFocused = useIsFocused();
    const actualRoute = useStateLink(GlobalContext.appbar.actualRouteRef);
    if(isFocused) {
        actualRoute.set(routes[index].name as any);
    }
    return <Component {...props} />
};
export default memo(Appbar);