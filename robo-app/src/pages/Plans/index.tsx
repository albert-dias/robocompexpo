// Import de pacotes
import React, { useEffect, useState } from 'react';
import { useStateLink, useStateLinkUnmounted } from '@hookstate/core';
import { Image, ImageBackground, StyleSheet, TouchableOpacity, View } from 'react-native';
import { Divider, Text } from 'react-native-paper';
import { FontAwesome5 } from '@expo/vector-icons';
import { ScrollView } from 'react-native-gesture-handler';

// Import de páginas
import { Button } from '../../components/Button';
import GlobalContext from '../../context';
import CardComponent, { CardContent, StyledCardTitle, StyledCardTitleTop } from '../../components/Card';
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';
import request from '../../util/request';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function Plans() {
    const [bool, setBool] = useState(false);

    return (
        <>
            <ContainerTop>
                <ImageBackground
                    source={imgBanner}
                    style={{
                        width: '100%',
                        // height: 160,
                        justifyContent: 'center',
                        alignItems: 'center',
                    }}>
                    <Image
                        source={logo}
                        resizeMode="contain"
                        style={{
                            width: 200,
                            height: 200,
                            marginTop: -30,
                            marginBottom: -50,
                        }} />
                    <TouchableOpacity
                        onPress={() => console.log('navigate(Home)')}
                        style={{
                            position: 'absolute',
                            alignSelf: 'flex-start',
                            marginLeft: '5%',
                            alignContent: 'flex-start',
                            alignItems: 'flex-start',
                        }}>
                        <FontAwesome5
                            name='chevron-left'
                            color={theme.colors.white}
                            size={40}
                        />
                    </TouchableOpacity>
                    <Text style={styles.textStyleF}>
                        Adquira um plano Profissional e aumente os seus GANHOS
                    </Text>
                </ImageBackground>
            </ContainerTop>

            <ScrollView style={{ backgroundColor: theme.colors.gray }}>
                <View style={styles.container}>
                    {/* {plans.value.map(plan => ( */}
                    <View style={styles.item} /* key={plan.id} */>
                        <CardComponent onPress={() => { console.log('myPlanPost(plan.id)') }}>
                            <CardContent style={/* (plan_id === plan.id) */(bool) ? styles.cardBox1 : styles.cardBox2}>
                                <Container vertical horizontal>
                                    <StyledCardTitleTop
                                        style={{ fontFamily: 'Manjari-Bold', color: theme.colors.green }}>
                                        plan.title
                                    </StyledCardTitleTop>
                                    <Text style={styles.textStyleCard}>plan.description</Text>
                                    <StyledCardTitle
                                        style={{
                                            fontFamily: 'Manjari-Bold',
                                            color: theme.colors.darkGray,
                                        }}>
                                        {'Por R$ $$ / mês'}
                                    </StyledCardTitle>
                                    <Divider />
                                    <Text
                                        style={{
                                            textAlign: 'center',
                                            fontSize: 18,
                                            fontFamily: 'Manjari-Bold',
                                            color: theme.colors.contrast,
                                        }}>
                                        Mais detalhes
                                    </Text>
                                </Container>
                            </CardContent>
                        </CardComponent>
                    </View>
                </View>
            </ScrollView>
        </>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    item: {
        marginVertical: 8,
        marginHorizontal: 16,
    },
    textStyleF: {
        fontSize: 20,
        color: 'white',
        textAlign: 'center',
        width: 300,
        paddingBottom: 20,
    },
    textStyleCard: {
        fontSize: 15,
        color: 'black',
        textAlign: 'justify',
    },
    textStyleCardFooter: {
        textAlign: 'center',
    },
    cardBox1: {
        borderRadius: 20,
        borderWidth: 1,
        borderColor: theme.colors.black,

    },
    cardBox2: {
        borderRadius: 20,
        borderWidth: 1,
        borderColor: 'transparent',
        borderBottomColor: theme.colors.red,
    },
});