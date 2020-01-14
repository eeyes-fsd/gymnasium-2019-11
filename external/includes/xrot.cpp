/*
 * Academic License - for use in teaching, academic research, and meeting
 * course requirements at degree granting institutions only.  Not for
 * government, commercial, or other organizational use.
 *
 * xrot.cpp
 *
 * Code generation for function 'xrot'
 *
 */

/* Include files */
#include "rt_nonfinite.h"
#include "indefinite_solve.h"
#include "xrot.h"

/* Function Definitions */
void b_xrot(double x_data[], int ix0, int iy0, double c, double s)
{
  int ix;
  int iy;
  int k;
  double temp;
  ix = ix0 - 1;
  iy = iy0 - 1;
  for (k = 0; k < 3; k++) {
    temp = c * x_data[ix] + s * x_data[iy];
    x_data[iy] = c * x_data[iy] - s * x_data[ix];
    x_data[ix] = temp;
    iy++;
    ix++;
  }
}

void xrot(int n, emxArray_real_T *x, int ix0, int iy0, double c, double s)
{
  int ix;
  int iy;
  int k;
  double temp;
  if (!(n < 1)) {
    ix = ix0 - 1;
    iy = iy0 - 1;
    for (k = 1; k <= n; k++) {
      temp = c * x->data[ix] + s * x->data[iy];
      x->data[iy] = c * x->data[iy] - s * x->data[ix];
      x->data[ix] = temp;
      iy++;
      ix++;
    }
  }
}

/* End of code generation (xrot.cpp) */
