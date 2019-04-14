############################
# Example for EPSLATEX     #
# Author: Toshiya Namikawa #
############################

# set styles
set style line 1 lt 3 lw 1 lc rgbcolor"black"
set style line 2 lt 2 lw 1 lc rgbcolor"black"
set style line 3 lt 1 lw 5 lc rgbcolor"orange"
set style line 4 lt 1 lw 5 lc rgbcolor"red"
set style line 5 lt 1 lw 5 lc rgbcolor"dark-red"

# set output
set term epsl co
set ou"sin.tex"

# define function
f(n,x) = 1/n**x
f(n,x) = (n==1) ? 1 : 1/n**x + f(n-1,x)

# plot
set xlabel"$s$"
set ylabel"Series for $\\zeta(s)$" 5
set format y "$10^{%L}$"
set log y
set xran[1:6]
set key reverse Left right top spacing 1.8
set label"$\\frac{\\pi^2}{6}$" at 2.3, pi**2/6
set label"$\\frac{\\pi^6}{945}$" at 5.2, pi**6/945*(1.1)
set arrow from 2.3,pi**2/6*(0.98) to 2,pi**2/6 
set arrow from 5.5,pi**6/945*(1.1) to 6,pi**6/945 
p f(4,x) ti"$\\sum_{n=1}^4(1/n)^x$" ls 3, \
f(16,x) ti"$\\sum_{n=1}^{16}(1/n)^x$" ls 4, \
f(64,x) ti"$\\sum_{n=1}^{64}(1/n)^x$" ls 5



