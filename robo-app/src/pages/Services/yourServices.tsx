// Import de pacotes
import React from 'react';
import { Image, ImageBackground, StyleSheet, Text, TouchableOpacity, View } from 'react-native';
import { ScrollView } from 'react-native-gesture-handler';
import { FontAwesome5 } from '@expo/vector-icons';
import { LinearGradient } from 'expo-linear-gradient';

// Import de páginas
import Container, { ContainerTop } from '../../components/Container';
import theme from '../../global/styles/theme';

// Import de imagens
import imgBanner from '../../../assets/images/banner.png';
import logo from '../../../assets/images/logo_branca_robocomp.png';

export function YourServices() {
    return (
        <>
            <View style={{ flexGrow: 1 }}>
                <ScrollView style={styles.scrollView}>
                    <ContainerTop>
                        <ImageBackground
                            source={imgBanner}
                            style={{
                                width: '100%',
                                justifyContent: 'center',
                                alignItems: 'center',
                            }}>
                            <Container
                                pb
                                // padding={30}
                                style={{
                                    flexDirection: 'column',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    width: '100%',
                                }}>
                                <Image
                                    source={logo}
                                    resizeMode='contain'
                                    style={{
                                        width: 200,
                                        height: 200,
                                        marginTop: -30,
                                        marginBottom: -50,
                                    }}
                                />
                                <TouchableOpacity
                                    onPress={() => console.log('navigation.navigate(Home)')}
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
                                    RoboComp - Meus Serviços
                                </Text>
                            </Container>
                        </ImageBackground>
                    </ContainerTop>
                    <View style={styles.viewn}>
                        <View style={styles.botao}>
                            <TouchableOpacity
                                activeOpacity={0.7}
                                onPress={() => {
                                    console.log('navigation.navigate(SSAdd)');
                                }}>
                                <LinearGradient
                                    colors={theme.colors.gradientInvert}
                                    start={{ x: 0.0, y: 1.0 }}
                                    end={{ x: 1.0, y: 1.0 }}
                                    style={styles.submit}
                                >
                                    <View style={styles.botaoPerfil}>
                                        <FontAwesome5 name='edit' size={25} color={'white'} />
                                        <Text style={styles.submitText}>CADASTRAR</Text>
                                    </View>
                                </LinearGradient>
                            </TouchableOpacity>
                        </View>
                        <View style={styles.botao}>
                            <TouchableOpacity
                                activeOpacity={0.7}
                                onPress={() => {
                                    console.log('navigation.navigate(SSShow)');
                                }}>
                                <LinearGradient
                                    colors={theme.colors.gradientInvert}
                                    start={{ x: 0.0, y: 1.0 }}
                                    end={{ x: 1.0, y: 1.0 }}
                                    style={styles.submit}>
                                    <View style={styles.botaoPerfil}>
                                        <FontAwesome5
                                            name='search'
                                            size={25}
                                            color={'white'}
                                        />
                                        <Text style={styles.submitText}>LISTAR</Text>
                                    </View>
                                </LinearGradient>
                            </TouchableOpacity>
                        </View>
                    </View>
                </ScrollView>
            </View>
        </>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    botao: {
        width: '100%',
        height: 60,
        borderRadius: 10,
        marginBottom: 20,
        marginTop: 10,
    },
    botaoPerfil: {
        flexDirection: 'row',
        justifyContent: 'flex-start',
        paddingLeft: '10%',
        paddingRight: '10%',
        alignItems: 'center',
    },
    scrollView: {
        flexGrow: 1,
        backgroundColor: theme.colors.gray,
    },
    submit: {
        marginRight: 40,
        marginLeft: 40,
        top: '10%',
        paddingTop: 20,
        paddingBottom: 20,
        backgroundColor: theme.colors.submit,
        borderRadius: 20,
        borderWidth: 1,
        borderColor: theme.colors.whitepure,
    },
    submitText: {
        color: theme.colors.whitepure,
        textAlign: 'center',
        fontSize: 21,
        marginLeft: '10%',
        // fontWeight: 'bold',
    },
    textStyle: {
        fontSize: 20,
        fontFamily: theme.fonts.bold,
        color: 'white',
        textAlign: 'center',
    },
    textStyleF: {
        fontSize: 16,
        paddingLeft: 20,
        paddingRight: 20,
        color: 'white',
        textAlign: 'center',
        padding: 3,
    },

    viewn: {
        marginTop: '10%',
        height: 'auto',
        justifyContent: 'space-around',
    },
});